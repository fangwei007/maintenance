<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_manage_users extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function find_all_users($start_row, $limit) {

        if ($this->session->userdata('role') != 'lbn') {// super admin can view all type of users
            $this->db->where('Role !=', 'lbn');
        }
        $result = $this->db->order_by('CreatedOn', 'desc')->get_where('users',array('Status !=' => 'D'), $limit, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_user_by_id($user_id) {
        $this->db->join('user_meta', 'user_meta.UserID = users.UserID');
        $result = $this->db->get_where('users', array('users.UserID' => $user_id), 1);
        if ($result->num_rows() === 1) {
            return $result->row();
        } else {
            return FALSE;
        }
    }

    public function find_user_by_nickname($nickname) {
        $sql = "SELECT * FROM users WHERE Nickname = '{$nickname}' LIMIT 1";
        $result = $this->db->query($sql);

        if ($result->num_rows() === 1) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_all_deleted_users(){
        $result = $this->db->get_where('users', array('Status' => 'D'));
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    
    
    public function create_new_user() {

        $data['Role'] = $this->input->post('role');
        $data['Status'] = $this->input->post('status');
        $data['Email'] = $this->input->post('email');       
        $data['Password'] = sha1($this->config->item('pre_pwd') . $this->input->post('password'));
        $data['CreatedOn'] = date('Y-m-d H:i:s', time());
        $data['CreatedFrom'] = $_SERVER['REMOTE_ADDR'];
        //create by one of admins, save the UserID of that admin
//        $data['CreatedBy'] = $this->session->userdata('user_id');
        $this->db->insert('users', $data);

        if ($this->db->affected_rows() === 1) {
            // inserted succesful
            //insert the user_id to the user_meta
            $result_meta = $this->db->get_where('users',array('Email' => $data['Email']));
            $meta_data['UserID'] = $result_meta->row()->UserID;
            $meta_data['Nickname'] = $this->input->post('nickname');
            $meta_data['Website'] = $this->input->post('website');
            $meta_data['Name'] = $this->input->post('name');
            $meta_data['Avatar'] = $this->config->item('default_avatar');
            $this->db->insert('user_meta', $meta_data);
            
            if ($this->db->affected_rows() === 1) {
                return TRUE;
            }else{
                return false;
            }   
        } else {
            return false;
        }
    }

    public function update_user() {
        $user_id = $this->input->post('user_id');
        $data['Email'] = $this->input->post('email');
        $data['Status'] = $this->input->post('status');
        $data['Role'] = $this->input->post('role');
        
        $meta_data['Nickname'] = $this->input->post('nickname');
        $meta_data['Name'] = $this->input->post('name');
        $meta_data['Phone'] = $this->input->post('phone');
        $meta_data['City'] = $this->input->post('city');
        $meta_data['Country'] = $this->input->post('country');
        $meta_data['State'] = $this->input->post('state');
        $meta_data['Biography'] = $this->input->post('bio');
        
        //get the current data to create the $history with updated data
        $his_result = $this->db->get_where('user_meta', array('UserID'=>$user_id),1);
        $older_userdata = $his_result->row();
        //create the history column in user history table
        $history = "";
        if(isset($older_userdata)){
            foreach($meta_data as $column_name=>$value){
                if($older_userdata->$column_name != $value){
                    $history .= "Update " . $column_name . " from " . $older_userdata->$column_name . " to " . $value . "; ";
                }
            }
        }

        //update the user info
        $this->db->where('UserID', $user_id);
        $this->db->update('users', $data);
        if ($this->db->affected_rows() >= 0) {
            $msg = "success";
            //insert updated info into user_history table
            $result = $this->insert_user_history($user_id, $this->session->userdata('user_id'), $history);
            if (!$result) {
                $msg = "user_history_error";
            }
            //update the user_meta info
            
            $this->db->where('UserID', $user_id);
            $this->db->update('user_meta', $meta_data);

            return $msg;
        } else {
            return FALSE;
        }
     
    }

    public function delete_user($user_id) {
//        $sql = "UPDATE users SET Status = 'D' WHERE UserID = {$user_id}";
//        $result = $this->db->query($sql);
        $this->db->where('UserID', $user_id);
        $this->db->update('users', array('Status' => 'D'));

        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function restore_user($user_id){
        $this->db->where('UserID', $user_id);
        $this->db->update('users', array('Status' => 'A'));

        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function perm_delete_user($user_id) {
        $this->db->delete('users', array('UserID' => $user_id));
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function retrieve_users() {
        $email = $this->input->post('email_search');
        $nickname = $this->input->post('name_search');
        $status = $this->input->post('status_search');
        $from_date = $this->input->post('fromDate_search');
        $to_date = $this->input->post('toDate_search');

        if (isset($email) && !empty($email)) {
            $this->db->like('Email', $email);
        }
        if (isset($nickname) && !empty($nickname)) {
            $this->db->like('Nickname', $nickname);
        }
        if (isset($status) && !empty($status)) {
            $this->db->where('Status', $status);
        }
        if (isset($from_date) && !empty($from_date)) {
            $this->db->where('CreatedOn >=', $from_date);
        }
        if (isset($to_date) && !empty($to_date)) {
            $this->db->where('CreatedOn <=', $to_date);
        }

        if ($this->session->userdata('role') != 'superman') {// super admin can search all type of users
            $this->db->where('Role =', 'client');
        }
        $result = $this->db->get('users');

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function check_user_id($user_id) {
        $result = $this->db->get_where('users', array('UserID' => $user_id), 1);
        $row = $result->row();
        if ($result->num_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_password($user_id, $new_password) {
        //encrypt the password
        $password = sha1($this->config->item('pre_pwd') . $new_password);
        $data = array('Password' => $password);
        //update the user password
        $this->db->where('UserID', $user_id);
        $this->db->update('users', $data);
        if ($this->db->affected_rows() === 1) {
            //search the return the client's email
//            $sql = "SELECT Email FROM users WHERE UserID = '{$user_id}' LIMIT 1";
//            $result = $this->db->query($sql);
            $result = $this->db->get_where('users', array('UserID' => $user_id), 1);
            $row = $result->row();
            if ($result->num_rows() === 1) {
                return $row->Email;
            } else {
                //this should never happen
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    private function insert_user_history($user_id, $updated_by, $history){
        
        $updated_on = date('Y-m-d H:i:s', time());
        $insert_arr = array('UserId'=>$user_id, 'UpdatedBy'=>$updated_by, 'History'=>$history, 'UpdatedOn'=>$updated_on);
        $this->db->insert('user_history', $insert_arr);
        
        if($this->db->affected_rows() === 1){
            // inserted succesful           
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /*
     * 4.13 wei fang
     */

    public function verify_user() {
        $user_id = $this->input->post('user_id');
        $verify_data['VerifyStatus'] = 'S';
        $verify_data['VerifiedOn'] = date('Y-m-d H:i:s', time());
        $this->db->where('VerifyUserID', $user_id);
        $this->db->update('verify', $verify_data);
        
        if ($this->db->affected_rows() >= 0) {
            $this->verify_status($user_id);
            return TRUE;
        } else {
            return FALSE;
            log_message('error','model_manage_users->verify_user failed');
        }
    }
    
    private function verify_status($user_id){
        $data['Status'] = 'V';
        $this->db->update('users', $data,  array('UserID' => $user_id));
        if ($this->db->affected_rows() <= 0) {
            log_message('error','model_manage_users->verify_status failed');
        }
    }
    
    private function email_verified_user($email){
        $this->load->library('email');
       
        $this->email->from('account@bridgeous.com', '比橙网');
        $this->email->to($email);
        $this->email->subject('恭喜！官方账户申请已通过审核！');
        $message = $this->load->view('email_tpl/email_user_verified','',TRUE);
        $this->email->message($message);
        if(!$this->email->send())
        {
            show_error($this->email->print_debugger());
        }
    }
    
    public function reject_user() {
        $user_id = $this->input->post('user_id');
        $verify_data['VerifyStatus'] = 'F';
        $verify_data['Feedback'] = $this->input->post('feedback');
        $this->db->where('VerifyUserID', $user_id);
        $this->db->update('verify', $verify_data);
        
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function process_verify($user_id) {
        $verify_data['VerifyStatus'] = 'A';
        $this->db->where('VerifyUserID', $user_id);
        $this->db->update('verify', $verify_data);
        
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function find_verify_user_by_id($user_id) {
        $this->db->join('user_meta', 'user_meta.UserID = verify.VerifyUserID')->join('users', 'users.UserID = verify.VerifyUserID');
        $result = $this->db->get_where('verify', array('VerifyUserID' => $user_id));

        if ($result->num_rows() === 1) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_verify_users_by_status($status, $start_row, $limit) {
        if ($status) {
            $this->db->join('user_meta', 'user_meta.UserID = verify.VerifyUserID')->join('users', 'users.UserID = verify.VerifyUserID');
            $result = $this->db->order_by('VerifyCreatedOn', 'desc')->get_where('verify', array('VerifyStatus' => $status), $limit, $start_row);
        } else {
            $this->db->join('user_meta', 'user_meta.UserID = verify.VerifyUserID')->join('users', 'users.UserID = verify.VerifyUserID');
            $result = $this->db->order_by('VerifyCreatedOn', 'desc')->get_where('verify', array(), $limit, $start_row);
        }
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

}
