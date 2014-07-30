<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $current_url = $this->input->get('url');
        $this->session->sess_destroy();
        //logout users from forum
        setcookie('Vanilla', ' ', time() - 3600, '/');
        unset($_COOKIE['Vanilla']);
        redirect($current_url,'location');
    }
}

?>