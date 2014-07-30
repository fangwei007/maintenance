<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!in_array($this->session->userdata('role'), $this->config->item('dashboard'))) {
            redirect('/display_errors/authenticate_error', 'location');
        }
    }
    
    public function index(){
        output_views('admin/dashboard/view_dashboard','','dashboard');
    }

    
}