<?php

if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );
 
class Language {
    private $user_language = '';
   
    public function preload_language(){ //this function is used to modify the language
        $ci = &get_instance();
        //set user's language
        if(!($ci->session->userdata('language'))){ //set default session language
            $ci->session->set_userdata('language','zh_cn');
        }
        if($ci->input->post('web_language')){ //fetch the language from dropdown list which sent by ajax
            $ci->session->set_userdata('language', $ci->input->post('web_language'));        
        }
        $this->user_language = $ci->session->userdata('language');
        $ci->config->set_item('language', $this->user_language);
        $ci->lang->load('view_'.$this->user_language, $this->user_language);
    }
   
}

?>
