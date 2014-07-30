<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_Form_validation Class
 *
 * Extends Form_Validation library
 *
 */
class MY_Form_validation extends CI_Form_validation {
    
    protected $ci;
    function __construct()
    {
        parent::__construct();
        $this->ci = get_instance();
    }

    public function no_special_character($str){
        //check if there is no special characters in the field
        $this->ci->form_validation->set_message('no_special_character' , $this->ci->lang->line('no_special_character'));
        $pattern = "/^[\pL0-9a-zA-Z]+$/u";
        return (bool) preg_match($pattern, $str);
    }
    
    public function is_existed($str, $field){
        //check the field is unique and only can be used by the current owner
        $this->ci->form_validation->set_message('is_existed' , $this->ci->lang->line('is_existed'));
        list($table, $field, $id)=explode('.', $field);
        $old_result = $this->ci->db->get_where($table, array('UserID'=>$id));
        $new_result = $this->ci->db->get_where($table, array($field => $str));
        return ($new_result->num_rows() === 0 || $old_result->row()->$field === $str) ? TRUE : FALSE;   
    }
    
    public function valid_url($str){
        $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
        if (!preg_match($pattern, $str)){
            $this->set_message('valid_url', lang('valid_url'));
            return FALSE;
        }
        return TRUE;
    }
        
}