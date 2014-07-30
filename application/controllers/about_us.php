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

//    public function contact_us() {
//        output_views('about_us/view_contact_us');
//    }

    public function contact_us() {
        if (isset($_POST['publish'])) {
            $this->form_validation->set_rules('title', 'lang:title', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('content', 'lang:content', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //user didn't validate, send back to add form and show errors
                output_views('about_us/view_contact_us', '');
            } else {
                //result returns true or false
                $result = $this->model_about_us->send_user_contact_msg();
                if ($result) {
                    //saved sucessful
                    $this->session->set_flashdata('msg', '发布成功！');
                    redirect('/about_us/contact_us', 'location');
                } else {
                    //saved sucessful
                    $this->session->set_flashdata('error', '发布失败！');
                    redirect('/about_us/contact_us', 'location');
                }
            }
        } else {
            output_views('about_us/view_contact_us', '');
        }
    }

    public function guest_contact_us() {
        if (isset($_POST['publish'])) {
            $this->form_validation->set_rules('title', 'lang:title', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[30]|valid_email|xss_clean');
            $this->form_validation->set_rules('name', 'lang:name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content', 'lang:content', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //user didn't validate, send back to add form and show errors
                output_views('about_us/view_guest_contact_us', '');
            } else {
                //result returns true or false
                $result = $this->model_about_us->send_guest_contact_msg();
                if ($result) {
                    //saved sucessful
                    $this->session->set_flashdata('msg', '发布成功！');
                    redirect('/about_us/guest_contact_us', 'location');
                } else {
                    //saved sucessful
                    $this->session->set_flashdata('error', '发布失败！');
                    redirect('/about_us/guest_contact_us', 'location');
                }
            }
        } else {
            output_views('about_us/view_guest_contact_us', '');
        }
    }

    public function terms() {
        output_views('about_us/view_terms_conditions');
    }

}
