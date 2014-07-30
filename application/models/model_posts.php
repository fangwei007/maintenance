<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_posts extends CI_Model{
    
    function __construct() {
        parent::__construct();
        $this->load->helper('upload_image_helper');
    }
    
    public function find_post_by_id($post_id){
        $result = $this->db->get_where('posts', array('PostID'=>$post_id), 1);
        if($result->num_rows() === 1){
            return $this->insert_following_status_to_row($result->row());
        }else {
            return FALSE;
        }       
    }
    
    public function find_post_author_by_type_category($category, $type, $limit, $offset){
        $this->db->join('user_meta', 'user_meta.UserID = posts.AuthorID');
        $result = $this->db->order_by('CreatedOn','desc')->get_where('posts', array('Category' => $category, 'Type' => $type, 'Status' => 'A', 'Level >='=>2), $limit, $offset);
        if($result->num_rows() > 0){
            return $result->result_array();
        }else {
            return FALSE;
        }
    }
    
    /*
     * Author: Wei Fang
     * Date: Mar.26th
     * Function: 收藏量
     */
    public function get_collection_count($post_id) {      
        $result = $this->db->select('Collection')->get_where('posts', array('PostID' => $post_id));
        if ($result->num_rows() === 1) {
            return $result->row();
        } else {
            return FALSE;
        }
        
    }
    
    /*
     * Author: Wei Fang
     * Date: Mar. 15th
     * Function: 访问量
     */

    public function get_views_count_info($ip, $post_id) {
        $count_views = $this->find_views_count_by_ip($ip, $post_id);
//        print_r($count_views);

        if (FALSE === $count_views) {
            //insert new record into count_views
            $result = $this->insert_views_count($post_id);
            return true;
        } else {
            //update old record in count_views
            $previous_time = strtotime($count_views[0]['LastViewTime']);
            $current_time = time();
            if (($current_time - $previous_time) >= 3600) {
                $result = $this->update_views_count($ip, $post_id,$count_views[0]['ViewsNum']);
            }
            return true;
        }
        return false;
    }

    public function find_views_count_by_id($post_id) {
        $result = $this->db->select_sum('ViewsNum')->get_where('count_views',array('PostID'=>$post_id));
        if ($result->num_rows() === 1) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    private function update_views_count($ip, $post_id, $old_count) {
        $data['ViewsNum'] = $old_count + 1;
        //update the user info
        $this->db->where(array('Ipaddress' => $ip, 'PostID' => $post_id));
        $this->db->update('count_views', $data);
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function find_views_count_by_ip($ip, $post_id) {
        $result = $this->db->get_where('count_views', array('IpAddress' => $ip, 'PostID' => $post_id), 1);
        if ($result->num_rows() === 1) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    private function insert_views_count($post_id) {
        $insert_arr = array();
        $insert_arr['PostID'] = $post_id;
        $insert_arr['IpAddress'] = $_SERVER['REMOTE_ADDR'];
        $insert_arr['Type'] = 'post';
        $insert_arr['LastViewTime'] = date('Y-m-d H:i:s', time());
        $insert_arr['ViewsNum'] = 1;
        $this->db->insert('count_views', $insert_arr);

        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return false;
        }
    }
    
    /*
     * Author: Wei Fang
     * Date: Mar. 9th
     * 
     */

    private function insert_following_status_to_row($posts_obj) {
        if (is_object($posts_obj)) {
            $result = $this->db->get_where('watch_lists', array('PostID' => $posts_obj->PostID, 'UserID' => $this->session->userdata('user_id')), 1);
            if ($result->num_rows() === 1) {
                //if current user is following the selected user
                $posts_obj->Stow = 1;
            }
        }
        return $posts_obj;
    }
    
}