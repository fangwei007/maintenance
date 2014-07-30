<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_manage_positions extends CI_Model {

    function __construct() {
        parent::__construct();
//        $this->load->helper('upload_image_helper');
    }

    public function find_position_by_id($position_id) {
        $result = $this->db->get_where('positions', array('PositionID' => $position_id), 1);

        if ($result->num_rows() === 1) {
            return $result->row();
        } else {
            return FALSE;
        }
    }

    public function find_all_published_positions($start_row, $per_page) {
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('positions', array('Status' => 'A'), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_all_deleted_positions($start_row, $per_page) {
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('positions', array('Status' => 'D'), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

//    public function create_position() {
//        
//        $data['Title'] = $this->input->post('title');
//        //$data['Field'] = $this->input->post('field');
//        $data['AuthorID'] = $this->session->userdata('user_id');
//        //$data['ExpiredOn'] = $this->input->post('expired_on');
//        $data['Description'] = $this->input->post('description');
//        $data['CreatedOn'] = date('Y-m-d H:i:s', time());
//        $data['CreatedFrom'] = $_SERVER['REMOTE_ADDR'];
//        $data['Status'] = 'A';
//        $data['Level'] = $this->config->item('default_post_level');
//
//        $this->db->insert('positions', $data);
//
//        if ($this->db->affected_rows() === 1) {
//            return 'success';
//        } else {
//            return FALSE;
//        }
//    }

    public function update_position() {
        $position_id = $this->input->post('position_id');
        $data['Title'] = $this->input->post('title');
        $data['Field'] = $this->input->post('field');
        $data['Country'] = $this->input->post('country');
        $data['JobType'] = $this->input->post('job_type');
        $data['Description'] = $this->input->post('description');
        $data['Level'] = $this->input->post('level');
        //$data['ExpiredOn'] = $this->input->post('expired_on');
        $data['UpdatedOn'] = date('Y-m-d H:i:s', time());

        $this->db->where('PositionID', $position_id)->update('positions', $data);
        if ($this->db->affected_rows() >= 0) {
            return $position_id;
        } else {
            return FALSE;
        }
    }

    public function delete_position($position_id) {
        $this->db->where('PositionID', $position_id)->update('positions', array('Status' => 'D'));
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function restore_position($position_id) {
        $this->db->where('PositionID', $position_id)->update('positions', array('Status' => 'A'));
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function perm_delete_position($position_id) {
        $this->db->delete('positions', array('PositionID' => $position_id));
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
