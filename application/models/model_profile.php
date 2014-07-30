<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_profile extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function find_user_info_by_nickname($nickname){
        $this->db->join('users', 'user_meta.UserID = users.UserID');
        $result = $this->db->get_where('user_meta', array('Nickname' => $nickname), 1);

        if ($result->num_rows() === 1) {
            return $this->insert_following_status_to_row($result->row());
        } else {
            return FALSE;
        }
    }
    
    private function insert_following_status_to_row($users_obj){
        if(is_object($users_obj)){
            $result = $this->db->get_where('follow_users', array('UserID'=>$users_obj->UserID, 'FollowerID' => $this->session->userdata('user_id')),1);
            if($result->num_rows() === 1){
                //if current user is following the selected user
                $users_obj->Follow = 1;
            }
        }
        return $users_obj;
    }
    
    public function find_posts_by_author_id($author_id, $limit, $offset){
        $result = $this->db->order_by('CreatedOn','desc')->get_where('posts', array('AuthorID' => $author_id), $limit, $offset);
        
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    public function find_positions_by_author_id($author_id, $limit, $offset){
        $result = $this->db->order_by('CreatedOn','desc')->get_where('positions', array('AuthorID' => $author_id), $limit, $offset);
        
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    public function find_verified_users_by_role_type($role_type, $limit, $offset) {
        $this->db->join('user_meta', 'user_meta.UserID = users.UserID');
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('users', array('Status' => 'V', 'Role' => $role_type), $limit, $offset);

        if ($result->num_rows() > 0) {
            //if user logged in, insert the following info
            if($this->session->userdata('user_id')){
                return $this->insert_following_status($result->result_array());
            }else{
                return $result->result_array();  
            }  
        } else {
            return FALSE;
        }
    }
    
    private function insert_following_status($users_array){
        if(is_array($users_array)){
            for($i = 0; $i < count($users_array); $i++){
                $result = $this->db->get_where('follow_users', array('UserID'=>$users_array[$i]['UserID'], 'FollowerID' => $this->session->userdata('user_id')),1);
                if($result->num_rows() === 1){
                    //if current user is following the selected user
                    $users_array[$i]['Follow'] = 1;
                }
            }
        }
        return $users_array;
    }
    
    public function unfollow_user($user_id){
        $data['UserID'] = $user_id;
        $data['FollowerID'] = $this->session->userdata('user_id');
        $this->db->delete('follow_users', $data);
        if ($this->db->affected_rows() > 0) {
            // inserted succesful
            return 'success';
        } else {
            return FALSE;
        }
    }
    
    public function follow_user($user_id){
        $data['UserID'] = $user_id;
        $data['FollowerID'] = $this->session->userdata('user_id');
        $data['CreatedOn'] = date('Y-m-d H:i:s', time());
        $this->db->insert('follow_users', $data);

        if ($this->db->affected_rows() === 1) {
            // inserted succesful
            return 'success';
        } else {
            return FALSE;
        }
    }
    
        
    public function del_watch_list($post_id, $post_type) {
        $data['PostID'] = $post_id;
        $data['UserID'] = $this->session->userdata('user_id');
        $this->db->delete('watch_lists', $data);
        $this->delete_collection_count($post_id, $post_type);
        if ($this->db->affected_rows() > 0) {
            // inserted succesful
            return 'success';
        } else {
            return FALSE;
        }
    }
    
    public function add_watch_list($post_id, $post_type) {
        $data['PostID'] = $post_id;
        $data['PostType'] = $post_type;
        $data['UserID'] = $this->session->userdata('user_id');
        $data['CreatedOn'] = date('Y-m-d H:i:s', time());
        $this->db->insert('watch_lists', $data);
        $this->insert_collection_count($post_id, $post_type);

        if ($this->db->affected_rows() === 1) {
            // inserted succesful
            return 'success';
        } else {
            return FALSE;
        }
    }
    
        /*
     * Author: Wei Fang
     * Date: Mar.26th
     * Function: 收藏量
     */

    private function insert_collection_count($post_id, $post_type) {
        switch ($post_type) {
            case 'post':
                $this->db->set('Collection', 'Collection+1', FALSE);
                $this->db->where('PostID', $post_id);
                $this->db->update('posts');
                break;
            case 'position':
                $this->db->set('Collection', 'Collection+1', FALSE);
                $this->db->where('PositionID', $post_id);
                $this->db->update('positions');
                break;
            default:
                break;
        }
    }

    private function delete_collection_count($post_id, $post_type) {
        switch ($post_type) {
            case 'post':
                $this->db->set('Collection', 'Collection-1', FALSE);
                $this->db->where('PostID', $post_id);
                $this->db->update('posts');
                break;
            case 'position':
                $this->db->set('Collection', 'Collection-1', FALSE);
                $this->db->where('PositionID', $post_id);
                $this->db->update('positions');
                break;
            default:
                break;
        }
    }
    
}