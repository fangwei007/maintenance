<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Display_errors extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function login_error() {
        $this->load->view('display_errors/view_login_error');
    }
    
    public function register_error(){
        output_views('display_errors/view_register_error');
    }
    
    public function post_error(){
        output_views('display_errors/view_post_error');
    }
}
