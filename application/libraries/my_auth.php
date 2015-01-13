<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_Auth {

    private $_ci;
    private $_sess_user = 'sess_user';
    private $_cookie_user = 'user_login';
    public $isRememberMe = FALSE;
    public $identity = "";
    public $credential = "";
    public $isValid = FALSE;
    public $error = "";
    public $userInfo = array();
    public $logintype = 'Frontend';
    public $userLoginId = 0;
    public $maxLoginAttempt = 5; // Current Login Attempt
    public $curLoginAttempt = 0;
    public $loginAttemptExceed = FALSE;
    public $loginFailBlockTime = 15; // 15 minutes;

    function __construct() {
        //parent::__construct();
        $this->_ci = & get_instance();
        $this->_ci->load->database();
        $this->_ci->load->library('encrypt', 'session');
        $this->_ci->load->model('muser');
        $this->_ci->load->model('muserlogin');
        $this->_ci->load->helper('cookie');
    }

    function setIdentity($input) {
        $this->identity = $input;
        return $this;
    }

    function setCredential($input) {
        $this->credential = $input;
        return $this;
    }

    function authenticate() {
        $this->isValid = FALSE;
        $email = $this->identity;
        $pass = $this->credential;

        // Check Login Attempt
        $this->loginAttemptCheck();
        if ($this->isExccedLoginAttempt()) {
            $this->error = 'Đăng nhập thất bại vượt quá số lần qui định vui lòng thử lại sau ' . $this->loginFailBlockTime . ' phút.';
            return FALSE;
        }

        $a_user = $this->_ci->muser->getInfoByEmail($email);

        if ($a_user) {
            $v_salt = $a_user->usersalt;

            if (md5(trim($pass) . $v_salt) == $a_user->password) {
                $this->userInfo = $a_user;

                // Reset Login Attempt Or Add Login Record
                if ($this->userLoginId) {
                    // Reset
                    $this->curLoginAttempt = 0;
                    $this->_updateLoginAttempt($this->userLoginId);
                } else {
                    // Add Login Record
                    $this->_addLoginRecord();
                }

                // Create User Session
                $this->_createUserSession();

                // Create User Cookie
                if ($this->isRememberMe) {
                    $this->_createUserLoginCookie();
                }

                // Update User Sesssion, IP, Last Login to database
                $this->_updateUserLastLogin();

                $this->isValid = TRUE;
                return TRUE;
            } else {

                $this->error = 'Thông tin đăng nhập không đúng.';
            }
        } else {

            $this->error = "Tài khoản không tồn tại.";
        }

        // Increase Login Attempt
        $this->curLoginAttempt++;

        // Update Login Attempt Or Add Login Record
        if ($this->userLoginId) {
            // Update
            $this->_updateLoginAttempt($this->userLoginId);
        } else {
            // Add Login Record
            $this->_addLoginRecord($email);
        }

        // Add More Error
        if ($this->isExccedLoginAttempt()) {
            $this->error .= ' Bạn đã đăng nhập thất bại vượt quá số lần qui định vui lòng thử lại sau ' . $this->loginFailBlockTime . ' phút.';
        } else {
            $this->error .= ' Bạn đã đăng nhập sai ' . $this->curLoginAttempt
                    . ' lần. Nếu bạn sai liên tiếp ' . $this->maxLoginAttempt
                    . ' lần. Bạn phải thử lại sau ' . $this->loginFailBlockTime . ' phút.';
        }
        return FALSE;
    }

    function getError() {
        return $this->error;
    }

    function loginFrontend() {
        $this->logintype = 'Frontend';
        return $this;
    }

    function loginBackend() {
        $this->logintype = 'Backend';
        return $this;
    }

    function loginAttemptCheck($ip_address = '') {
        if (!$ip_address) {
            $ip_address = $this->_ci->input->ip_address();
        }
        $a_login = $this->_ci->muserlogin->getLastLoginByIpAddress($ip_address);
        if ($a_login) {
            return TRUE;
        } else {
            return TRUE;
        }
    }

    function isExccedLoginAttempt() {
        if ($this->curLoginAttempt >= $this->maxLoginAttempt)
            return TRUE;
        else
            return FALSE;
    }

    function isLogin() {
        // Check the User Session
        $a_user = $this->getUserSession();
        
        if (!empty($a_user) && isset($a_user['id']) && isset($a_user['session_id'])) {
            $this->userInfo = $a_user;
            return TRUE;
        } else {
            // Check Cookie 
            $s_cookie = $this->_getUserLoginCookie();
            if ($s_cookie != '') {

                $a_user_cookie = json_decode($this->_ci->encrypt->decode($s_cookie), TRUE);
                debug($a_user_cookie);
                if (isset($a_user_cookie['userid']) && isset($a_user_cookie['passwd'])) {
                    // Check Login Info
                    $a_user = $this->_ci->muser->checkLogin($a_user_cookie['userid'], $a_user_cookie['passwd']);
                    if ($a_user) {
                        $this->_createUserSession(); // Create Session to mark as Login
                        $this->_createUserLoginCookie(); // Renew Cookie extend the expire time
                        $this->_updateUserLastLogin(); // Update new Login Time, Session Id
                        $this->userInfo = $this->getUserSession();
                        return TRUE;
                    } else {
                        $this->userLogout(); // Destroy Bad Cookie;
                    }
                }
            }
            return FALSE;
        }
    }

    /**
     * Kiểm tra xem có phải login từ máy tính khác hay ko. TRUE => Đang Login từ máy khác.
     * @return boolean
     */
    function isMultipleLogin() {
        if ($this->isLogin()) {
            $a_user = $this->getUserSession();
            $u = $a_user['id'];
            $session_id = $a_user['session_id'];
            if ($this->_ci->muser->checkLoginSession($u, $session_id)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    function setRememberMe($bool) {
        $this->isRememberMe = $bool;
        return $this;
    }

    function getUserSession() {
        return $this->_ci->session->userdata($this->_sess_user);
    }

    function userLogout() {
        // Destroy session and Cookie
        $this->_ci->session->unset_userdata($this->_sess_user);
        delete_cookie($this->_cookie_user);
    }

    function isMember() {
        if (isset($this->userInfo['type']) && $this->userInfo['type'] == 'MEMBER' || $this->userInfo['type'] == 'ADMIN')
            return TRUE;
        else
            return FALSE;
    }

    function isAdmin() {
        if (isset($this->userInfo['type']) && $this->userInfo['type'] == 'ADMIN')
            return TRUE;
        else
            return FALSE;
    }

    function isBackend() {
        if (isset($this->userInfo['logintype']) && $this->userInfo['logintype'] == 'Backend')
            return TRUE;
        else
            return FALSE;
    }

    private function _addLoginRecord($email = '') {
        $a_user = $this->userInfo;
        if (empty($a_user)) {
            $userID = 0;
            $username = 'Unknown';
        } else {
            $userID = $a_user->id;
            $username = $a_user->username;
        }
        $a_userlogin = array(
            'id' => $userID,
            'username' => $username,
            'logintype' => $this->logintype,
            'ipaddress' => $this->_ci->input->ip_address(),
            'loginattempt' => $this->curLoginAttempt,
            'email' => $email
        );
        return
                $this->_ci->muserlogin->add($a_userlogin);
    }

    private function _updateLoginAttempt() {
        $a_userlogin = array(
            'loginattempt' => $this->curLoginAttempt,
            'UserLoginDate' => datetimeNow()
        );
        return $this->_ci->muserlogin->update($a_userlogin, $this->userLoginId);
    }

    private function _createUserSession() {
        $a_userInfo = $this->userInfo;
        $a_user = array(
            'id' => $a_userInfo->id,
            'username' => $a_userInfo->username,
            'useremail' => $a_userInfo->email,
            'status' => $a_userInfo->status,
            'type' => $a_userInfo->type,
            'name' => $a_userInfo->name,
            'ipaddress' => $this->_ci->input->ip_address(),
            'session_id' => $this->_ci->session->userdata('session_id'), // Prevent Session Id change by CI
            'logintype' => $this->logintype
        );
        $this->_ci->session->set_userdata($this->_sess_user, $a_user);

        return TRUE;
    }

    private function _createUserLoginCookie() {
        $a_user = array(
            'userid' => $this->userInfo->id,
            'passwd' => $this->userInfo->password);

        $a_cookie = array(
            'name' => $this->_cookie_user,
            'value' => $this->_ci->encrypt->encode(json_encode($a_user)),
            'expire' => 7 * 24 * 60 * 60,
            //'domain' => '.some-domain.com',
            'path' => '/',
                //'secure' => TRUE
        );
        $this->_ci->input->set_cookie($a_cookie);
    }

    private function _getUserLoginCookie() {
        return $this->_ci->input->cookie($this->_cookie_user);
    }

    private function _updateUserLastLogin() {
        
    }

}
