<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_home extends CI_Model {

    public function find_all_articles_videos($limit) {
        $type = array('article', 'video');
        $this->db->where(array('Status' => 'A', 'Level' => 4));
        $this->db->where_in('Type', $type);
        $result = $this->db->order_by("CreatedOn", "desc")->get('posts', $limit);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_more_articles_videos($limit, $offset){
        $type = array('article', 'video');
        $this->db->where(array('Status' => 'A', 'Level' => 4));
        $this->db->where_in('Type', $type);
        $result = $this->db->order_by("CreatedOn", "desc")->get('posts', $limit, $offset);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    public function find_author_name_by_id($author_id){
        $result = $this->db->select('Nickname')->get_where('user_meta', array('UserID'=>$author_id));
        if ($result->num_rows() > 0) {
            return $result->row()->Nickname;
        } else {
            return FALSE;
        }
    }
    
//    public function find_all_videos($limit) {
//        $result = $this->db->order_by("CreatedOn", "desc")->get_where('posts', array('Status' => 'A', 'Type' => 'video', 'Level' => 4), $limit);
//
//        if ($result->num_rows() > 0) {
//            return $result->result_array($limit);
//        } else {
//            return FALSE;
//        }
//    }

    public function find_all_events($limit) {
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('posts', array('Status' => 'A', 'Type' => 'event', 'Level' => 4), $limit);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_all_positions($limit) {
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('positions', array('Status' => 'A','Level' => 4), $limit);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_all_zones_school($limit) {
        $this->db->join('user_meta', 'user_meta.UserID = users.UserID');
        $result = $this->db->order_by("CreatedOn", "random")->get_where('users', array('Status' => 'V', 'Role' => 'school'), $limit);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_all_zones_industry($limit) {
        $this->db->join('user_meta', 'user_meta.UserID = users.UserID');
        $result = $this->db->order_by("CreatedOn", "random")->get_where('users', array('Status' => 'V', 'Role' => 'industry'), $limit);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_all_zones_person($limit) {
        $this->db->join('user_meta', 'user_meta.UserID = users.UserID');
        $result = $this->db->order_by("CreatedOn", "random")->get_where('users', array('Status' => 'V', 'Role' => 'client'), $limit);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

}
