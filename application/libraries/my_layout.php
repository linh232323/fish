<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_layout {

    var $obj;
    var $layout;
    var $loadedData = array();
    var $app_a_default_js = array();
    var $app_a_default_css = array();
    var $app_a_frontend_js = array();
    var $app_a_frontend_css = array();
    var $app_a_backend_js = array();
    var $app_a_backend_css = array();
    var $app_a_lib_js = array();
    var $app_a_lib_css = array();
    var $app_page_title = "";
    
    function My_layout($layout = "") {
        $this->obj = & get_instance();
        $this->layout = $layout;
        $this->app_page_title = "";
    }

    function setLayout($layout) {
        $this->layout = $layout;
    }

    function setPageTitle($v_title){
        $this->app_page_title = $v_title;
    }
    
    function setDefaultJs($a_js) {
        if (!is_array($a_js)) {
            return false;
        } else {
            $this->app_a_default_js = $a_js;
        }
    }

    function setDefaultCss($a_css) {
        if (!is_array($a_css)) {
            return false;
        } else {
            $this->app_a_default_css = $a_css;
        }
    }

    function setFrontendJs($a_js) {
        if (!is_array($a_js)) {
            return false;
        } else {
            $this->app_a_frontend_js = $a_js;
        }
    }

    function setFrontendCss($a_css) {
        if (!is_array($a_css)) {
            return false;
        } else {
            $this->app_a_frontend_css = $a_css;
        }
    }

    function setBackendJs($a_js) {
        if (!is_array($a_js)) {
            return false;
        } else {
            $this->app_a_backend_js = $a_js;
        }
    }

    function setBackendCss($a_css) {
        if (!is_array($a_css)) {
            return false;
        } else {
            $this->app_a_backend_css = $a_css;
        }
    }
    
    function setLibJs($a_js) {
        if (!is_array($a_js)) {
            return false;
        } else {
            $this->app_a_lib_js = $a_js;
        }
    }

    function setLibCss($a_css) {
        if (!is_array($a_css)) {
            return false;
        } else {
            $this->app_a_lib_css = $a_css;
        }
    }

    function view($view, $data = null, $return = false) {

        $this->loadedData['app_content_for_layout'] = $this->obj->load->view($view, $data, true);

        $this->loadedData['app_a_default_css']  = $this->app_a_default_css;
        $this->loadedData['app_a_default_js']   = $this->app_a_default_js;
        $this->loadedData['app_a_frontend_css'] = $this->app_a_frontend_css;
        $this->loadedData['app_a_frontend_js']  = $this->app_a_frontend_js;
        $this->loadedData['app_a_backend_css']  = $this->app_a_backend_css;
        $this->loadedData['app_a_backend_js']   = $this->app_a_backend_js;
        $this->loadedData['app_a_lib_css']      = $this->app_a_lib_css;
        $this->loadedData['app_a_lib_js']       = $this->app_a_lib_js;
        $this->loadedData['app_page_title']     = $this->app_page_title;        
        if ($return) {
            $output = $this->obj->load->view($this->layout, $this->loadedData, true);
            return $output;
        } else {
            $this->obj->load->view($this->layout, $this->loadedData, false);
        }
    }

}