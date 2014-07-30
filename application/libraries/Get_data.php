<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_data {
    protected $ci;
    public function __construct(){
        $this->ci = get_instance();
    }
    
    public function find_userdata_by_post_id($post_id=''){
        $this->ci->db->join('user_meta', 'user_meta.UserID = posts.AuthorID');
        $result = $this->ci->db->get_where('posts', array('PostID'=>$post_id), 1);
        
        if($result->num_rows() === 1){
            return $this->insert_following_status_to_row($result->row());
        }else {
            return FALSE;
        }
    }
    
    public function find_userdata_by_position_id($position_id=''){
        $this->ci->db->join('user_meta', 'user_meta.UserID = positions.AuthorID');
        $result = $this->ci->db->get_where('positions', array('PositionID'=>$position_id), 1);
        
        if($result->num_rows() === 1){
            return $this->insert_following_status_to_row($result->row());
        }else {
            return FALSE;
        }
    }
    
    private function insert_following_status_to_row($users_obj){
        if(is_object($users_obj)){
            $result = $this->ci->db->get_where('follow_users', array('UserID'=>$users_obj->UserID, 'FollowerID' => $this->ci->session->userdata('user_id')),1);
            if($result->num_rows() === 1){
                //if current user is following the selected user
                $users_obj->Follow = 1;
            }
        }
        return $users_obj;
    }
    
    public function find_latest_articles($limit){
        $w_data['Type'] = 'article';
        $w_data['Status'] = 'A';
        $w_data['Level >='] = 2;
        $result = $this->ci->db->get_where('posts', $w_data, $limit);
        
        if($result->num_rows() > 0){
            return $result->result_array();
        }else {
            return FALSE;
        }
    }
    
    public function find_latest_videos(){
        
    }
    
    public function find_latest_events($limit){
        $w_data['Type'] = 'event';
        $w_data['Status'] = 'A';
        $w_data['Level >='] = 2;
        $result = $this->ci->db->get_where('posts', $w_data, $limit);
        
        if($result->num_rows() > 0){
            return $result->result_array();
        }else {
            return FALSE;
        }
    }
    
    public function find_latest_positions($limit){
        $w_data['Status'] = 'A';
        $w_data['Level >='] = 2;
        $result = $this->ci->db->get_where('positions', $w_data, $limit);
        
        if($result->num_rows() > 0){
            return $result->result_array();
        }else {
            return FALSE;
        }
    }
    
}