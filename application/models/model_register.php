<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_register extends CI_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    private $email_code; //has value set within set_session method
    
    public function insert_user(){
        $role = $this->input->post('role');
        $insert_arr = array();
        $insert_arr['Email'] = $this->input->post('email');
        $insert_arr['Password'] = sha1($this->config->item('pre_pwd').$this->input->post('password'));
        $insert_arr['Status'] = 'N';
        $insert_arr['Role'] = empty($role) ? "client" : $role;
        $insert_arr['CreatedOn'] = date('Y-m-d H:i:s', time());
        $insert_arr['CreatedFrom']= $_SERVER['REMOTE_ADDR'];
        $this->db->insert('users', $insert_arr);
        
        if($this->db->affected_rows() === 1){
            // inserted succesful
            //then insert the user id to the user_meta table in the set_session function
            $this->set_session($insert_arr['Email']);
            $this->email_code = md5((string)$insert_arr['CreatedOn']);
            $this->send_validation_email($insert_arr['Email']);           
//            print_r($this->session->all_userdata());//for testing
            return TRUE;
        }else{
            return false;
        }
        
    }
    
    public function validate_email($email_address, $email_code){
        $sql = "SELECT CreatedOn FROM users WHERE Email = '{$email_address}' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();
        
        if($result->num_rows() ===1){
            if(md5((string)$row->CreatedOn === $email_code)){
                $activate_result = $this->activate_account($email_address);
                if($activate_result === 'TRUE'){
                    $this->set_session_from_vali($email_address);
                    return 'TRUE';
                }else{
                    return $activate_result;
                }
            }
        }else{
            //this should never happen
            echo 'There was an error validating your email. Please contact the admin';
        }       
    }
    
    private function set_session($email)
    {
        $sql = "SELECT * FROM users WHERE Email = '{$email}' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();
        $sess_data = array(
            'user_id' => $row->UserID,
            'email' => $email,
            'nickname'=>$this->input->post('nickname'),
            'role' => $row->Role,
            'status' => $row->Status,
            'logged_in' => 1
        );
        //$this->email_code = md5((string)$row->CreatedOn);
        $this->session->set_userdata($sess_data);
        
        //insert the user_id to the user_meta table if it's not existed
        $result_meta = $this->db->get_where('user_meta',array('UserID' => $row->UserID));
        if($result_meta->num_rows() != 1){
            $data['UserID'] = $row->UserID;
            $data['Website'] = ($this->input->post('website')) ? $this->input->post('website') : '';
            $data['Nickname'] = $this->input->post('nickname');
            $data['Name'] = $this->input->post('name');
            $data['Avatar'] = $this->config->item('default_avatar');
            $this->db->insert('user_meta', $data);
        }
    }
    
    private function set_session_from_vali($email){
        $this->db->join('user_meta', 'user_meta.UserID = users.UserID');
        $result = $this->db->get_where('users',array('Email' => $email));
        if($result->num_rows() === 1){
            $row = $result->row();
            $sess_data = array(
            'user_id' => $row->UserID,
            'email' => $email,
            'nickname'=>$row->Nickname,
            'role' => $row->Role,
            'status' => $row->Status,
            'logged_in' => 1
            );
            $this->session->set_userdata($sess_data);
        }
    }
    
    private function send_validation_email($email){
        $this->load->library('email');
        $email_code = $this->email_code;
       
        $this->email->from('account@bridgeous.com', '比橙网');
        $this->email->to($email);
        $this->email->subject('请激活您比橙网的账号');
        //$this->email->reply_to('noreply@noreply.com');
        
        $message = '<!DOCTYPE html><head>
                    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
                    </head><body>';
        $message .= '<p>亲爱的用户：</p>';
        // the link we send will look like /american_stock_world/register/validate_email/email_adress/md5_code
        $message .= '<p>感谢您注册比橙网！请点击以下链接来激活您的账户<p/>';
        $message .= '<p>' . base_url() .'register/validate_email/'  . $email .'/'. $email_code . '</p>';
        $message .= '<p>如不能点击请复制上面的链接到您的地址栏，谢谢！<p/>';
        $message .= '</body></html>';
        
        $this->email->message($message);
//        $this->email->send();
        if(!$this->email->send())
        {
            show_error($this->email->print_debugger());
        }
    }
    
    
    
    public function activate_account($email_address){
        
        $this->db->where('Email', $email_address);
        $result = $this->db->get('users');
        $row = $result->row();
        if($row->Status === 'N'){
            $data = array('Status'=>'A');
            $this->db->where('Email', $email_address);
            $this->db->update('users', $data);
            if($this->db->affected_rows() === 1){
                $this->session->set_userdata('status', 'A');
                return 'TRUE';
            }else{
                return 'updated_failed';
            }
        }elseif($row->Status === 'A'){
            return 'activated';
        }else{
            return 'blocked';
        }
        
        
    }
}

