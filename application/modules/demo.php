<?php

class Demo extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index() {        
        $this->my_layout->set_layout("layout/backend_demo", $this->app_data);
        $this->my_layout->set_backend_js(array('function'));
        $this->my_layout->view('demo',$this->app_data);        
    }

}