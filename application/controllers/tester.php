<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tester extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function email_tester_ci() {
//        $config['protocol'] = 'smtp';
//        $config['smtp_host'] = 'mail.bridgeous.com';
//        $config['smtp_port'] = '26';
//        $config['smtp_timeout'] = '30';
//        $config['smtp_user'] = 'account+bridgeous.com';
//        $config['smtp_pass'] = 'bridgeous_account_127';
//        $config['charset'] = 'utf-8';
//        $config['newline'] = "\r\n";
//        $config['mailtype'] = 'html'; // or html
//        $config['validate'] = TRUE; // bool whether to validate email or not 
//        $config['crlf'] = "\r\n";
        
        $this->load->library('email');
       
        $this->email->from('account@bridgeous.com', 'test');
        $this->email->to('252737481@qq.com');
        $this->email->subject('Please activate your account.');
        $this->email->set_newline("\r\n");
        //$this->email->reply_to('noreply@noreply.com');
        
        $message = '<!DOCTYPE html><head>
                    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
                    </head><body>';
        $message .= '<p>Thank you!haha</p>';
        $message .= '</body></html>';
        
        $this->email->message($message);
//        $this->email->send();
        if(!$this->email->send())
        {
            show_error($this->email->print_debugger());
        }else{
            echo $this->email->print_debugger();
        }
    }
    
    public function email_tester_mailer(){
        require_once ('PHPMailer/class.phpmailer.php');
        require_once ('PHPMailer/class.smtp.php');

        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->FromName = '比橙';
        $mail->From = 'account@bridgeous.com';
        $mail->AddAddress('252737481@qq.com');
        $mail->Subject = 'User register error';
        $message = 'Hello world!';
        $mail->Body = $message;
        $result = $mail->Send();
        echo $result ? 'successful' : $mail->ErrorInfo;
    }
    
    public function sql(){
         $result = $this->db->group_by('PostID')->having('PostAuthorID',cur_user_id())->get('comments');
         if ($result->num_rows() > 0) {
             var_dump($result->result_array());
         }
    }
}