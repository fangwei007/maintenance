<?php

class Model_positions extends CI_Model{
    
    function __construct() {
        parent::__construct();
//        $this->load->helper('upload_image_helper');
    }
    
    public function find_position_by_id($position_id){
        $result = $this->db->get_where('positions', array('PositionID'=>$position_id), 1);
        if($result->num_rows() === 1){
            return $this->insert_following_status_to_row($result->row());
        }else {
            return FALSE;
        }       
    }
    
    public function find_position_author($limit, $offset){
        $this->db->join('user_meta', 'user_meta.UserID = positions.AuthorID');
        $result = $this->db->order_by('CreatedOn','desc')->get_where('positions', array('Status'=>'A'), $limit, $offset);
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

    public function find_position_by_filters($limit, $offset, $filters) {
        $this->db->join('user_meta', 'user_meta.UserID = positions.AuthorID');

        $this->db->order_by('CreatedOn', 'desc')->from('positions');

        foreach ($filters as $key => $filter) {
            $this->db->where_in('positions.' . $key, $filter);
        }
        $result = $this->db->limit($limit, $offset)->get();

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_all_positions_by_filters($filters) {
//        unset($filters['submit']);
        $this->db->join('user_meta', 'user_meta.UserID = positions.AuthorID');

        $this->db->order_by('CreatedOn', 'desc')->from('positions');

        foreach ($filters as $key => $filter) {
            $this->db->where_in('positions.' . $key, $filter);
        }
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }
    
    public function get_collection_count($position_id) {
        $result = $this->db->select('Collection')->get_where('positions', array('PositionID' => $position_id));
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

    public function get_views_count_info($ip, $position_id) {
        $count_views = $this->find_views_count_by_ip($ip, $position_id);
//        print_r($count_views);

        if (FALSE === $count_views) {
            //insert new record into count_views
            $result = $this->insert_views_count($position_id);
            return true;
        } else {
            //update old record in count_views
            $previous_time = strtotime($count_views[0]['LastViewTime']);
            $recent_time = time();
            if (($recent_time - $previous_time) >= 3600) {
                $result = $this->update_views_count($ip, $position_id, $count_views[0]['ViewsNum']);
            }
            return true;
        }
        return false;
    }

    public function find_views_count_by_id($position_id) {
        $result = $this->db->select_sum('ViewsNum')->get_where('count_views',array('PostID'=>$position_id));
        if ($result->num_rows() === 1) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    private function update_views_count($ip, $position_id, $old_count) {
        $data['ViewsNum'] = $old_count + 1;
        //update the user info
        $this->db->where(array('Ipaddress' => $ip, 'PostID'=>$position_id));
        $this->db->update('count_views', $data);
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function find_views_count_by_ip($ip, $position_id) {
        $result = $this->db->get_where('count_views', array('IpAddress' => $ip, 'PostID' => $position_id), 1);
        if ($result->num_rows() === 1) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    private function insert_views_count($position_id) {
        $insert_arr = array();
        $insert_arr['PostID'] = $position_id;
        $insert_arr['IpAddress'] = $_SERVER['REMOTE_ADDR'];
        $insert_arr['Type'] = 'position';
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
    private function insert_following_status_to_row($positions_obj) {
        if (is_object($positions_obj)) {
            $result = $this->db->get_where('watch_lists', array('PostID' => $positions_obj->PositionID, 'UserID' => $this->session->userdata('user_id')), 1);
            if ($result->num_rows() === 1) {
                //if current user is following the selected user
                $positions_obj->Stow = 1;
            }
        }
        return $positions_obj;
    }
    
    /*
     * Author: Wei Fang
     * Date: Apr. 21th
     * 
     */
    public function retrieve_positions($keyword) {
        $this->db->like('Title', $keyword, 'both');
        $this->db->or_like('Description', $keyword, 'both');
        $this->db->where('Status', 'A');

        $result = $this->db->get('positions');
        if ($result->num_rows() > 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function find_position_by_keywords($limit, $offset, $keyword) {
        $this->db->join('user_meta', 'user_meta.UserID = positions.AuthorID');
        $this->db->order_by('CreatedOn', 'desc')->from('positions');
        $this->db->like('Title', $keyword);
        $this->db->or_like('Description', $keyword);
        $result = $this->db->limit($limit, $offset)->get();

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    
    
}

