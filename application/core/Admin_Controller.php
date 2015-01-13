<?php

class Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->my_layout->setPageTitle("SALE TOOL User Manager");
        $this->load->library(array("email", "session", "my_auth"));
        $this->load->helper(array('my_pagination'));

        if ($this->app_action == 'add' || $this->app_action == 'update') {
            $this->load->library('form_validation');
            $this->form_validation->CI = & $this;
        }

        /* Authenticate */
        // If not Login
        $this->app_data['login_url'] = $this->app_base_url . $this->app_module . "/login";
        
        if ($this->app_controller != 'login') {
           
            if (!$this->my_auth->isLogin()) {
            //   redirect($this->app_data['login_url']);
            }
            else {
                $this->app_data['userInfo'] = $this->my_auth->getUserSession();
                // Kiem tra Multiple Login
                if ($this->my_auth->isMultipleLogin()) {
                    $this->my_auth->userLogout();
                    $this->session->set_flashdata('sess_user_message', 'Bạn đã đăng nhập từ nơi khác, vui lòng đăng nhập lại.');
                   // redirect($this->app_data['login_url']);
                }

                // Is Admin, And Login Type is Backend
                if (!($this->my_auth->isAdmin() || $this->my_auth->isMember()) || !$this->my_auth->isBackend()){
                    $this->session->set_flashdata('sess_user_message', 'Bạn không có quyền hạn truy cập vào khu vực này.');
                    redirect($this->app_data['login_url']);
                }
            }
        }
        /* End Authenticate */
    }

}