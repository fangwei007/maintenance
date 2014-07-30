<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class About_us extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('model_about_us');
    }

    public function index() {
        $this->about_bg();
    }

    public function about_bg() {
        output_views('about_us/view_about_bg');
    }

    public function contact_us() {
        output_views('about_us/view_contact_us');
    }

//    public function contact_us() {
//        output_views('about_us/view_contact_us');
//    }

    public function report_bug() {
        if (isset($_POST['publish'])) {
            $this->form_validation->set_rules('title', 'lang:title', 'trim|required|max_length[100]|xss_clean');
            if (!$this->session->userdata('logged_in')) {
                $this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[30]|valid_email|xss_clean');
                $this->form_validation->set_rules('name', 'lang:name', 'trim|required|xss_clean');
            }
            $this->form_validation->set_rules('content', 'lang:content', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //user didn't validate, send back to add form and show errors
                output_views('about_us/view_report_bug', '');
            } else {
                //result returns true or false
                $result = $this->model_about_us->send_contact_msg();
                if ($result) {
                    //saved sucessful
                    $this->session->set_flashdata('msg', '提交成功！');
                    redirect('/about_us/report_bug', 'location');
                } else {
                    //saved sucessful
                    $this->session->set_flashdata('error', '提交失败！');
                    redirect('/about_us/report_bug', 'location');
                }
            }
        } else {
            output_views('about_us/view_report_bug', '');
        }
    }

    public function terms() {
        output_views('about_us/view_terms_conditions');
    }

}
