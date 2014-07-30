<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_login extends CI_Model{
    
    public function login_user() {
        $this->load->helper('cookie');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $remember_me = $this->input->post('remember_me');

        $sql = "SELECT * FROM users WHERE Email = '{$email}' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();
        if($result->num_rows() === 1) {
            if($row->Status != 'D') {
                if($row->Password === sha1($this->config->item('pre_pwd').$password)) {
                    // authenticated, now update the user's session
                    //get nickname
                    $meta_result = $this->db->get_where('user_meta',array('UserID'=>$row->UserID),1);
                    $meta_row = $meta_result->row();
                    $session_data = array(
                        'user_id' => $row->UserID,
                        'nickname'=>$meta_row->Nickname,
                        'avatar'=>$meta_row->Avatar,
                        'email' => $email,
                        'role' => $row->Role,
                        'status' => $row->Status,
                        'logged_in' => 1
                    );
                    // set the session
                    $this->session->set_userdata($session_data);
                    //$this->set_session($session_data);
                    if($remember_me){
                        setcookie('email', $email, time()+60*60*24*365, '/');
                    }
                    return 'logged_in';
                }else {
                    return 'incorrect_password';
                }
            }else {
                //the account has been suspended or has been deleted
                return 'not_available';
            }
        }else {
            //email address not found in database
            return 'email_not_found';
        }
        
    }
    
    public function email_exists($email) {
        $sql = "SELECT Email, Role FROM users WHERE Email = '{$email}' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();
        
        return ($result->num_rows() === 1 && $row->Email) ? $row->Role : false;
    }
    
    public function verify_reset_password_code($email, $code){
        $sql = "SELECT Role, Email FROM users WHERE Email = '{$email}' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();
        
        if($result->num_rows() === 1){
            return ($code ==md5($this->config->item('pre_pwd').$row->Role)) ? TRUE : FALSE;
        }else {
            return FALSE;
        }
    }
    
    public function update_password() {
        $email = $this->input->post('email');
        $password = sha1($this->config->item('pre_pwd').$this->input->post('password'));
        
        $sql = "UPDATE users SET Password = '{$password}' WHERE Email = '{$email}' LIMIT 1";
        $update_success = $this->db->query($sql);
        
        if($update_success) {
            //activate the account which is inactivate
            $this->db->select('Status');
            //get_where('mytable', array('id' => $id), $limit, $offset);
            $result = $this->db->get_where('users', array('email' => $email), 1);
            $row = $result->row();
            if($row->Status === 'N'){
                $this->load->model('model_register');
                $activate_result = $this->model_register->activate_account($email);
                if(!$activate_result){echo "This account cannot be activated automatically.";}
            }
            return TRUE;
        }else {
            return FALSE;
        }
    }
    
}
?>
