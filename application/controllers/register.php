<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('model_register');
        //$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        $this->register_user();
    }
    
    public function register_user(){       
        //rules of register
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[30]|valid_email|is_unique[users.Email]|xss_clean');
        $this->form_validation->set_rules('nickname', 'lang:nickname', 'trim|required|no_special_character|is_unique[user_meta.Nickname]|max_length[20]|xss_clean');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[6]|matches[passconf]|max_length[30]|xss_clean');
        $this->form_validation->set_rules('passconf', 'lang:passconf', 'trim|required'); 

        if($this->form_validation->run() === FALSE){
            //user didn't validate, send back to register form and show errors
            $vali_error['st'] = 0;
            $vali_error['email'] = form_error('email', '<div class="error-msg">', '</div>');
            $vali_error['nickname'] = form_error('nickname', '<div class="error-msg">', '</div>');
            $vali_error['password'] = form_error('password', '<div class="error-msg">', '</div>');
            $vali_error['passconf'] = form_error('passconf', '<div class="error-msg">', '</div>');

            echo json_encode($vali_error);
        }else{
            //successful register
            //returns TRUE OR FALSE
            $result = $this->model_register->insert_user();

            if($result){
                echo json_encode(array('st'=>1));
            }else {
                echo json_encode(array('st'=>0, 'msg' => '登陆失败'));
            }
        }
    }
    
    public function register_official_user($role=''){
        if(empty($role)){ redirect('/display_errors/register_error', 'location'); } //show error page when role is empty
        $data['role'] = $role;
        if (isset($_POST['submit'])) {
            //rules of register
            $this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[30]|valid_email|is_unique[users.Email]|xss_clean');
            $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[6]|matches[passconf]|max_length[30]|xss_clean');
            $this->form_validation->set_rules('passconf', 'lang:passconf', 'trim|required');
            $this->form_validation->set_rules('nickname', 'lang:display_name', 'trim|required|no_special_character|is_unique[user_meta.Nickname]|max_length[20]|xss_clean');
            $this->form_validation->set_rules('name', 'lang:name', 'trim|required|max_length[50]|xss_clean');
            $this->form_validation->set_rules('website', 'lang:website', 'trim|required|valid_url|max_length[200]|xss_clean');

            if($this->form_validation->run() === FALSE){

                output_views('register/view_register_official_user',$data);
            }else{
                //successful register
                $result = $this->model_register->insert_user();

                if($result){
                    redirect('/', 'location');
                }else {
                    $this->session->set_flashdata('error', '注册失败！');
                    redirect('/register/register_official_user', 'location');
                }
            }
        }else{
            output_views('register/view_register_official_user',$data);
        }
    }
    
    public function validate_email($email_address, $email_code)
    {
        $email_code = trim($email_code);
        $validated = $this->model_register->validate_email($email_address, $email_code);
        
        if($validated === 'TRUE'){
            $data['email_address'] = $email_address;
            output_views('register/view_email_validated', $data);
        }else{
            switch ($validated) {
                case 'blocked':
                    $data['error'] = lang('blocked_account');
                    output_views('register/view_email_validation_failed', $data);
                    break;
                case 'activated':
                    $data['error'] = lang('already_activated');
                    output_views('register/view_email_validation_failed', $data);
                    break;
                default:
                    $data['error'] = lang('failed_to_activate');
                    output_views('register/view_email_validation_failed', $data);
                    break;
            } 
        }
    }
}
?>
