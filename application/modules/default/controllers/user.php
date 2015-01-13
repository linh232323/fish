<?php

class User extends MY_Controller {

    private $_default_module = "default/";
    private $_sess_register  = 'sess_register';

    function __construct() {
        parent::__construct();
        $this->load->model("muser");
        $this->load->helper('captcha');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('my_auth');
        $this->form_validation->CI = & $this;

        // PreConfig Some link
        $this->_configLink();

        $this->app_data['isLogin'] = $this->my_auth->isLogin();
        // For Testing. Tu dong kiem tra login khi load Controller.
        // If not Login
        if (!$this->app_data['isLogin']) {
            $a_unauth_action = array('login', 'register', 'registered', 'resendEmail', 'forgot', 'reset');
            if (!in_array($this->router->method, $a_unauth_action))
                redirect($this->app_data['login_url']);
        }else {
            $this->app_data['userInfo'] = $this->my_auth->getUserSession();

            // Kiem tra Multiple Login
            if ($this->my_auth->isMultipleLogin()) {
                $this->my_auth->userLogout();
                $this->session->set_flashdata('sess_user_message', 'Bạn đã đăng nhập từ nơi khác, vui lòng đăng nhập lại.');
                redirect($this->app_data['login_url']);
            }
        }

        // Get Flash Data 
        $this->app_data['flash_message'] = $this->session->flashdata('sess_user_message');
    }

    private function _configLink() {
        // Config some link
        $this->app_data['register_url'] = $this->app_base_url . $this->_default_module . 'user/register';
        $this->app_data['forgot_url']   = $this->app_base_url . $this->_default_module . "user/forgot";
        $this->app_data['resend_url']   = $this->app_base_url . $this->_default_module . "user/resendEmail";
        $this->app_data['login_url']    = $this->app_base_url . $this->_default_module . "user/login";
        $this->app_data['logout_url']   = $this->app_base_url . $this->_default_module . "user/logout";
    }

    public function index() {
        $this->my_layout->setPageTitle('User Home');
        $this->my_layout->view('/user/index', $this->app_data);
    }

    public function register() {
        $this->my_layout->setPageTitle('Đăng ký thành viên');
        $this->app_data['user'] = $this->muser->mockItem();

        $this->form_validation->set_rules('UserFullName', 'họ tên', 'required|min_length[6]');
        $this->form_validation->set_rules('UserName', 'Username', 'required|max_length[25]|callback_validUserName');
        $this->form_validation->set_rules('UserPasswd', 'mật khẩu', 'required');
        $this->form_validation->set_rules('UserPasswd2', 'xác nhận mật khẩu', 'required|matches[UserPasswd]');
        $this->form_validation->set_rules('UserEmail', 'Email', 'required|valid_email|callback_validEmail');
        $this->form_validation->set_rules('CaptchaText', 'mã bảo vệ', 'required|callback_validCaptcha');
        //$this->form_validation->set_rules('UserAddress' , 'Address'     , 'required');
        //$this->form_validation->set_rules('UserPhone'   , 'Phone number', 'required|callback_validPhone');
        //$this->form_validation->set_rules('UserNo'      , 'User No'     , 'required|exact_length[9]');
        //$this->form_validation->set_rules('UserNoDate'  , 'User NoDate' , 'required');
        //$this->form_validation->set_rules('UserNoPlace' , 'User NoPlace', 'required');
        $this->form_validation->set_rules('PolicyAgree', 'Điều khoản', 'callback_validPolicyAgree');
        if ($this->form_validation->run() == FALSE) {

            // Creating Captcha Image
            $a_cap                          = $this->_createCaptcha();
            $this->app_data['captchaImage'] = $a_cap['image'];

            $this->form_validation->set_error_delimiters('<span class="text-error">', '</span>');
            $this->my_layout->view('/user/register_form', $this->app_data);
        }
        else {
            // Register New User, Send Validation Code to the Email
            $v_salt       = createRandomString(5);
            $a_insert_row = array(
                'UserFullName'   => trim($this->input->post('UserFullName')),
                'UserName'       => trim($this->input->post('UserName')),
                'usersalt'       => $v_salt,
                'UserPasswd'     => md5($this->input->post('UserPasswd') . $v_salt),
                'UserEmail'      => trim($this->input->post('UserEmail')),
                //'UserAddress'    => $this->input->post('UserAddress'),
                //'UserPhone'      => $this->input->post('UserPhone'),
                //'UserNo'         => $this->input->post('UserNo'),
                //'UserNoDate'     => $this->input->post('UserNoDate'),
                //'UserNoPlace'    => $this->input->post('UserNoPlace'),
                'UserType'       => 'MEMBER',
                'UserStatus'     => 'DEACTIVE',
                'UserCreateDate' => datetimeNow(),
                'UserUpdateDate' => datetimeNow(),
            );
            if ($this->muser->add($a_insert_row)) {

                $v_sent = $this->_sendValidationEmail($a_insert_row['UserEmail']);
                $this->session->set_userdata($this->_sess_register, TRUE);
                redirect($this->app_base_url . $this->_default_module . 'user/registered');
            }
            else {
                $this->app_data['message'] = 'Lỗi tạo dữ liệu';
                $this->my_layout->view('backend/elements/404', $this->app_data);
            }
        }

        //$this->my_layout->view('register_form',$this->app_data);
    }

    public function login() {
        // Check isLogin or Not
        if ($this->my_auth->isLogin()) {
            redirect($this->app_base_url . $this->_default_module . 'user');
        }
        $this->my_layout->setPageTitle('Đăng nhập');

        // Link
        // Remember Me
        $this->app_data['is_remember'] = FALSE;
        if ($this->input->post('RememberMe') == 'yes') {
            $this->app_data['is_remember'] = TRUE;
        }
        $this->form_validation->set_rules('UserEmail', 'email', 'required|valid_email');
        $this->form_validation->set_rules('UserPasswd', 'mật khẩu', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('<span class="text-error">', '</span>');
            $this->my_layout->view('/user/login_form', $this->app_data);
        }
        else {

            // Tien hành đang nhập
            $email  = $this->input->post('UserEmail');
            $passwd = $this->input->post('UserPasswd');
            $this->my_auth->setIdentity($email)
                    ->setCredential($passwd)
                    ->setRememberMe($this->app_data['is_remember']);
            if ($this->my_auth->authenticate()) {
                // Login Successfully -> create session, set cookie if need
                $this->session->set_flashdata('sess_user_message', 'Bạn đã đăng nhập thành công.');
                redirect($this->app_base_url . $this->_default_module . 'user');
            }
            else {
                $this->app_data['error'] = $this->my_auth->getError();
            }

            $this->my_layout->view('/user/login_form', $this->app_data);
        }
    }

    public function profile() {
        $a_user_session = $this->my_auth->getUserSession();
        $a_user         = $this->muser->getInfo($a_user_session['UserId']);
    }

    public function forgot() {
        $this->my_layout->setPageTitle('Tìm lại mật khẩu');
        $this->form_validation->set_rules('UserEmail', 'Email', 'required|valid_email|callback_validSendForgotPassEmail');
        $this->form_validation->set_rules('CaptchaText', 'mã bảo vệ', 'required|callback_validCaptcha');
        if ($this->form_validation->run() == FALSE) {
            // Create Captcha Image
            $a_cap                          = $this->_createCaptcha();
            $this->app_data['captchaImage'] = $a_cap['image'];
            
            $this->form_validation->set_error_delimiters('<span class="text-error">', '</span>');
            $this->app_data['is_sent'] = FALSE;
            $this->my_layout->view('/user/forgot_form', $this->app_data);
        }
        else {
            $this->app_data['is_sent'] = TRUE;
            $this->app_data['email']   = trim($this->input->post('UserEmail'));
            $this->my_layout->view('/user/forgot_form', $this->app_data);
        }
    }

    public function reset() {
        $this->my_layout->setPageTitle('Đặt lại mật khẩu');
        $email   = strtolower($this->input->get('email'));
        $v_token = $this->input->get('token');

        // Kiem tra input
        if (!$email || !$v_token) {
            redirect($this->app_base_url);
        }

        // Kiem tra user
        $this->app_data['message']  = "";
        $this->app_data['is_reset'] = false;
        $a_user                     = $this->muser->getInfoByEmail($email);
        if ($a_user && $a_user->UserRequestToken == $v_token) {
            $this->app_data['user'] = $this->muser->mockItem();
            $this->form_validation->set_rules('UserPasswd', 'mật khẩu mới', 'required');
            $this->form_validation->set_rules('UserPasswd2', 'xác nhận mật khẩu mới', 'required|matches[UserPasswd]');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<span class="text-error">', '</span>');
                $this->my_layout->view('/user/reset_form', $this->app_data);
                return;
            }
            else {
                // Update UserPasswd, Remove Request Token
                $a_update_row = array(
                    'UserRequestToken' => '',
                    'UserPasswd'       => md5($this->input->post('UserPasswd') . $a_user->usersalt)
                );
                if ($this->muser->update($a_update_row, $a_user->UserId)) {
                    $this->app_data['is_reset'] = true;
                    $this->app_data['message']  = 'Bạn đã đổi mật khẩu mới thành công, bạn đã có thể đăng nhập.';
                }
            }
        }
        else {
            $this->app_data['message'] = 'Yêu cầu không hợp lệ.';
        }

        $this->my_layout->view('/user/reset_form', $this->app_data);
    }

    public function logout() {
        $this->my_auth->userLogout();
        $this->session->set_flashdata('sess_user_message', 'Bạn đã đăng xuất.');
        //echo $this->session->flashdata('sess_user_message');
        redirect($this->app_base_url . $this->_default_module . 'user');
    }

    public function registered() {
        if ($this->session->userdata($this->_sess_register) == TRUE) {

            $this->my_layout->view('/user/register_complete', $this->app_data);
            $this->session->unset_userdata($this->_sess_register);
        }
        else {
            redirect($this->app_data['login_url']);
        }
    }

    public function resendEmail() {
        $this->my_layout->setPageTitle('Yêu cầu gửi mail kích hoạt');
        $this->form_validation->set_rules('UserEmail', 'Email', 'required|valid_email|callback_validResendEmail');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('<span class="text-error">', '</span>');
            $this->app_data['is_sent'] = FALSE;
            $this->my_layout->view('/user/resend_form', $this->app_data);
        }
        else {
            $this->app_data['is_sent'] = TRUE;
            $this->app_data['email']   = trim($this->input->post('UserEmail'));
            $this->my_layout->view('/user/resend_form', $this->app_data);
        }
    }

    public function validUserName($username) {
        if ($this->muser->checkUser($username) == TRUE) {
            return TRUE;
        }
        else {
            $this->form_validation->set_message('validUserName', 'Tên đăng nhập đã được sử dụng. Vui lòng chọn tên khác.');
            return FALSE;
        }
    }

    public function validPolicyAgree($value) {
        if ($value == 'agree') {
            return TRUE;
        }
        else {
            $this->form_validation->set_message('validPolicyAgree', 'Thành viên đăng ký phải đồng ý các điều khoản của website.');
            return FALSE;
        }
    }

    public function validResendEmail($email) {
        $v_sent = $this->_sendValidationEmail($email);

        if ($v_sent === TRUE) {
            return TRUE;
        }
        else {
            $this->form_validation->set_message('validResendEmail', $v_sent);
            return FALSE;
        }
    }

    public function validSendForgotPassEmail($email) {
        $v_sent = $this->_sendForgotPassEmail($email);

        if ($v_sent === TRUE) {
            return TRUE;
        }
        else {
            $this->form_validation->set_message('validSendForgotPassEmail', $v_sent);
            return FALSE;
        }
    }

    /**
     * Kiểm tra thông tin email
     * @param String $email
     * @return boolean
     */
    public function validEmail($email) {
        if ($this->muser->checkEmail($email) == TRUE) {
            return TRUE;
        }
        else {
            $this->form_validation->set_message('validEmail', 'Email này đã được đăng kí. Vui lòng chọn email khác.');
            return FALSE;
        }
    }

    public function validCaptcha($captchaText) {
        $a_store_cap = $this->session->userdata('sess_captcha');
        if ($captchaText == $a_store_cap['word'] && $this->input->ip_address() == $a_store_cap['ip_address']) {
            return TRUE;
        }
        else {
            $this->form_validation->set_message('validCaptcha', 'Mã captcha không đúng, vui lòng nhập lại.');
            return FALSE;
        }
    }

    public function validation() {
        $this->my_layout->setPageTitle('Kích hoạt tài khoản');
        $email = strtolower($this->input->get('email'));
        $code  = $this->input->get('code');
        // Kiem tra input
        if (!$email || !$code) {
            redirect($this->app_base_url);
        }

        // Kiem tra user
        $message   = "";
        $is_active = false;
        $a_user    = $this->muser->getInfoByEmail($email);
        if ($a_user) {
            $userid = $a_user->UserId;
            if ($a_user->UserStatus == 'DEACTIVE') {
                $v_salt = $a_user->usersalt;
                if ($code == md5($email . $v_salt)) {
                    // Update UserStatus
                    $a_update_row = array('UserStatus' => 'ACTIVE');
                    if ($this->muser->update($a_update_row, $userid)) {
                        $is_active = true;
                        $message   = 'Bạn đã kích hoạt tài khoản thành công, bạn đã có thể đăng nhập.';
                    }
                    else {
                        $message = 'Có lỗi xảy ra vui lòng báo với Admin hoặc thử lại sau.';
                    }
                }
                else {
                    $message = 'Mã kích hoạt không hợp lệ.';
                }
            }
            else {
                $is_active = true;
                $message   = 'Thành viên đã kích hoạt tài khoản.';
            }
        }
        else {
            $message = 'Mã kích hoạt không hợp lệ.';
        }

        $this->app_data['is_active'] = $is_active;
        $this->app_data['message']   = $message;
        $this->my_layout->view('/user/validation_complete', $this->app_data);
    }

    private function _sendForgotPassEmail($email) {
        $error  = "";
        $email  = strtolower($email);
        $a_user = $this->muser->getInfoByEmail($email);

        if ($a_user) {
            $v_token = md5(createRandomString(5));

            // Update to User Request Token
            if ($this->muser->setRequestToken($a_user->UserId, $v_token)) {
                $this->app_data['reset_link'] = $this->app_base_url . 'default/user/reset?email=' . $email . '&token=' . $v_token;
                $this->app_data['username']   = $a_user->UserName;
                $email_body                   = $this->load->view('/user/forgot_email', $this->app_data, true);

                // Send Email
                $this->load->library('email');
                $config = array(
                    'useragent' => '',
                    'mailtype'  => 'html');
                $this->email->initialize($config);
                $this->email->from('norely@localhost.com', 'QHO Training');
                $this->email->to($email);
                //$this->email->to('qxcuong@gmail.com');
                $this->email->subject('QHO - Tìm lại mật khẩu');
                $this->email->message($email_body);
                if ($this->email->send()) {
                    return TRUE;
                }
                else {
                    $error = 'Lỗi khi send email, vui lòng thử lại sau.';
                }
            }
            else {
                $error = 'Lỗi hệ thống, vui lòng thử lại sau.';
            }
        }
        else {
            $error = "Email không tồn tại.";
        }
        return $error;
    }

    private function _sendValidationEmail($email) {
        $error  = "";
        $email  = strtolower($email);
        $a_user = $this->muser->getInfoByEmail($email);

        if ($a_user) {
            if ($a_user->UserStatus != 'DEACTIVE') {
                $error = "Thành viên đã kích hoạt tài khoản.";
            }
            else {
                $v_salt                        = $a_user->usersalt;
                $s_code                        = md5($email . $v_salt);
                $this->app_data['active_link'] = $this->app_base_url . 'default/user/validation?email=' . $email . '&code=' . $s_code;

                $this->app_data['username'] = $a_user->UserName;
                $email_body                 = $this->load->view('/user/validation_email', $this->app_data, true);

                // Send Email
                $this->load->library('email');
                $config = array(
                    'useragent' => '',
                    'mailtype'  => 'html');
                $this->email->initialize($config);
                $this->email->from('norely@localhost.com', 'QHO Training');
                $this->email->to($email);
                //$this->email->to('qxcuong@gmail.com');
                $this->email->subject('QHO - kích hoạt tài khoản');
                $this->email->message($email_body);
                if ($this->email->send()) {
                    return TRUE;
                }
                else {
                    $error = "Lỗi khi send email, vui lòng thử lại sau.";
                }
            }
        }
        else {
            $error = "Email không tồn tại.";
        }
        return $error;
    }

    private function _createCaptcha() {
        $a_cap_options = array(
            'img_path'   => './asset/public/captcha/',
            'img_url'    => $this->app_base_url . 'asset/public/captcha/',
            'img_width'  => 170,
            'img_height' => 40,
            'border'     => 0,
            'expiration' => 5
        );
        $a_cap       = create_captcha($a_cap_options);        
        $a_store_cap = array(
            'word'       => $a_cap['word'],
            'ip_address' => $this->input->ip_address()
        );
        $this->session->set_userdata('sess_captcha', $a_store_cap);
        echo $a_cap['word']; // For testing
        return $a_cap;
    }

}