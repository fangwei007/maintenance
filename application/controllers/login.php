<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('model_login');
        $this->load->library('form_validation');
    }
    
    public function index() {
        output_views('login/view_login');
    }
    
    public function login_user() {
        //login form validation
        $this->form_validation->set_rules('email', '电子邮箱', 'trim|required|max_length[30]|valid_email|xss_clean');
        $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[30]');
        
        if($this->form_validation->run() == FALSE) {
            //user didn't validate, send back to login form and show errors
            $vali_error['st'] = 0;
            $vali_error['email'] = form_error('email', '<div class="error-msg">', '</div>');
            $vali_error['password'] = form_error('password', '<div class="error-msg">', '</div>');

            echo json_encode($vali_error);
        }else{
            //initial checks on data are ok, now check if they are valid credentials or not
            $result = $this->model_login->login_user();
            
            switch($result) {
                case 'logged_in':
                    $vali_suc['st'] = 1;
                    echo json_encode($vali_suc);
                    break;
                case 'incorrect_password':
                    $vali_error['st'] = 0;
                    $vali_error['error'] = "密码错误！";
                    echo json_encode($vali_error);
                    break;
                case 'not_available':
                    $vali_error['st'] = 0;
                    $vali_error['error'] = "此用户暂不可用！";
                    echo json_encode($vali_error);
                    break;
                case 'email_not_found':
                    $vali_error['st'] = 0;
                    $vali_error['error'] = "邮箱不存在";
                    echo json_encode($vali_error);
                    break;
            }
        }
    }//end of login_user function
    
    public function reset_password() {
        if(isset($_POST['email'])&&!empty($_POST['email'])) {
            //first check if its a valid email or not
            $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[30]|valid_email|xss_clean');
            
            if($this->form_validation->run() == FALSE) {
                //email didn't validate, send back to reset password form and show errors
                output_views('login/view_login');
            }else {
                $email = trim($this->input->post('email'));
                $result = $this->model_login->email_exists($email);
                
                if($result) {
                    //if we found the email, $result is their role
                    $this->send_reset_password_email($email, $result);
                    $data['email'] = $email;
                    output_views('login/view_reset_password_sent' , $data);
                }else {
                    $data['error'] = 'Email address is not existed';
                    output_views('login/view_reset_password' , $data);
                }
            }
        }else {
            output_views('login/view_reset_password');
        }
    }
    
    public function reset_password_form($email, $email_code){
        if(isset($email, $email_code)) {
            $email = trim($email);
            //$email_hash is used to prevent users to change other's password by hacking the url
            $email_hash = sha1($email . $email_code);
            $verified = $this->model_login->verify_reset_password_code($email, $email_code);
            
            if($verified){
                $data['email_hash'] = $email_hash;
                $data['email'] = $email;
                $data['email_code'] = $email_code;
                output_views('login/view_update_password', $data);
            }else {
                //send back to reset_password page, not update password, if there was a problem
                $data['error'] = lang('verify_failed');
                output_views('login/view_reset_password', $data); 
            }
        }
    }
    
    public function update_password() {
        if(!isset($_POST['email'],$_POST['email_hash'])|| $_POST['email_hash'] !== sha1($_POST['email'] . $_POST['email_code'])){
            // Either a hacker or they changed their email in the email field, redirect to home page.
            redirect('/', 'location');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[30]|matches[password_conf]|xss_clean');
        $this->form_validation->set_rules('password_conf', 'New Password Again', 'trim|required|min_length[6]|max_length[30]|xss_clean');
        
        if($this->form_validation->run() == FALSE) {
            //email didn't validate, send back to reset password form and show errors
            output_views('login/view_update_password');
        }else {
            //successful update
            //result returns ture or false
            $result = $this->model_login->update_password();

            if($result){
                output_views('login/view_update_password_success');
            }else {
                //update failed
                $data['error'] = lang('updated_failed');
                output_views('login/view_update_password', $data);
            }
        }
    }
    
    public function resend_vali_email(){
        if(isset($_POST['submit'])){
            $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[30]|valid_email|xss_clean');
            if($this->form_validation->run() == FALSE) {
                output_views('login/view_resend_vali_email');
            }else{
                //initial checks on data are ok, now check if they are valid credentials or not
                $result = $this->model_login->resend_vali_email();

                switch($result) {
                    case 'sent':
                        //sent email successfully
                        setcookie('resend_email', 'no', time()+60, '/'); //users cannot resend validation email in 60 secs
                        //$data['error'] = $this->lang->line('Validation email has sent');
                        //output_views('login/view_resend_vali_email', $data);
                        $this->session->set_flashdata('msg', $this->lang->line('Validation email has sent'));
                        redirect('login/resend_vali_email', 'location');
                        break;
                    case 'activated':
                        //email already has been activated
                        $data['error'] = $this->lang->line('This email has already been activated');
                        output_views('login/view_resend_vali_email', $data);
                        break;
                    case 'not_available':
                        //email has been deleted or suspended
                        $data['error'] = $this->lang->line('This email is not available');
                        output_views('login/view_resend_vali_email', $data);
                        break;
                    default :
                        //email cannot be found
                        $data['error'] = $this->lang->line('This email is not existed');
                        output_views('login/view_resend_vali_email', $data);
                        break;
                }
            }
        }else{
            output_views('login/view_resend_vali_email');
        }
    }
    
    
    
    
    
    private function send_reset_password_email($email, $role){
        $email_code = md5($this->config->item('pre_pwd') . $role);
        $this->load->library('email');       
        $this->email->from('account@bridgeous.com', '比橙网');
        $this->email->to($email);
        $this->email->subject(lang('email_change_password_subj'));
//        $this->email->reply_to('noreply@noreply.com');
        
        $message = '<!DOCTYPE html><head>
                    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
                    </head><body>';
        $message .= '<p>亲爱的比橙用户（ ' . $email . '）</p>';
        // the link we send will look like /bridgeous/register/validate_email/email_adress/md5_code
        $message .= '<p>请点击以下链接来修改您的密码</p>';
        $message .= '<p>' . base_url() .'login/reset_password_form/'  . $email .'/'. $email_code . '</p>';
        $message .= '<p>如不能点击请复制上面的链接到您的地址栏，谢谢！</p>';
        $message .= '</body></html>';
        
        $this->email->message($message);
        if(!$this->email->send())
        {
            show_error($this->email->print_debugger());
        }
    }
    
    
    
}
?>
