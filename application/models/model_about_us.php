<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_about_us extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private function get_user_info() {
        $user_id = $this->session->userdata('user_id');
        //find user's info from users table
        $user_result = $this->db->get_where('users', array('UserId' => $user_id), 1);
        if ($user_result->num_rows() === 1) {
            $row = $user_result->row();
            //find user's info from user_meta table
            $meta_result = $this->db->get_where('user_meta', array('UserId' => $user_id), 1);
            if ($meta_result->num_rows() === 1) {
                //insert the email to the meta array
                $meta_row = $meta_result->row();
                $meta_row->Email = $row->Email;
                return $meta_row;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function send_user_contact_msg() {
        $user_data = $this->get_user_info();
        $title = $this->input->post('title');
        $email = $user_data->Email;
        $name = $user_data->Name;
        $content = $this->input->post('content');

        $this->load->library('email');
        $this->email->from('account@bridgeous.com', '比橙网');
        $this->email->to('feedbacks@bridgeous.com');
        $this->email->subject($title);
        //$this->email->reply_to('noreply@noreply.com');

        $message = '<!DOCTYPE html><head>
                    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
                    </head><body>';
        $message .= '<p>用户邮箱:' . $email . '</p>';
        $message .= '<p>用户名称:' . $name . '</p>';
        $message .= '<p>问题描述:' . $content . '</p>';
        $message .= '<p>问题提交时间:' . date('Y-m-d H:i:s') . '</p>';
        $message .= '</body></html>';

        $this->email->message($message);
        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
        }
        return true;
    }

    public function send_guest_contact_msg() {
        $title = $this->input->post('title');
        $email = $this->input->post('email');
        $name = $this->input->post('name');
        $content = $this->input->post('content');

        $this->load->library('email');
        $this->email->from('account@bridgeous.com', '比橙网');
        $this->email->to('feedbacks@bridgeous.com');
        $this->email->subject($title);
        //$this->email->reply_to('noreply@noreply.com');

        $message = '<!DOCTYPE html><head>
                    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
                    </head><body>';
        $message .= '<p>用户邮箱:' . $email . '</p>';
        $message .= '<p>用户名称:' . $name . '</p>';
        $message .= '<p>问题描述:' . $content . '</p>';
        $message .= '<p>问题提交时间:' . date('Y-m-d H:i:s') . '</p>';
        $message .= '</body></html>';

        $this->email->message($message);
        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
        }
        return true;
    }

}
