<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manage_positions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!in_array($this->session->userdata('role'), $this->config->item('manage_positions'))) {
            redirect('/display_errors/authenticate_error', 'location');
        }
        $this->load->library('pagination');
        $this->load->model('model_manage_positions');
    }

    public function index() {
        $this->show_published_positions();
    }

    public function show_published_positions($offset = 0) {//checked
        //config the pagination
        $config['base_url'] = base_url() . 'admin/manage_positions/show_published_positions/';
        $config['total_rows'] = $this->db->get_where('positions', array('Status' => 'A'))->num_rows();
        $config['per_page'] = 20;
        $data['pagination'] = output_pagination($config);
        $data['type'] = "position"; //set it for the post/position header

        //return an array contains all published positions
        $data['published_positions_list'] = $this->model_manage_positions->find_all_published_positions($offset, $config['per_page']); //return an array contains all published positions
        output_views('admin/manage_positions/view_published_positions', $data, 'dashboard');
    }

    public function edit_position($position_id = '') {
        //return an array contains all position's info
        $position_info = $this->model_manage_positions->find_position_by_id($position_id);
        if (isset($_POST['publish'])) {
            $this->load->library('form_validation');

             //rules of updating
            $this->form_validation->set_rules('title', 'lang:title', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('field', 'lang:field', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'lang:country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('job_type', 'lang:job_type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('level', 'lang:level', 'trim|required|xss_clean');
            $this->form_validation->set_rules('description', 'lang:description', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //user didn't validate, send back to edit form and show errors
                output_views('admin/manage_positions/view_edit_position', $position_info, 'dashboard');
            } else {
                //successful updated
                //return the updated position's id           
                $result = $this->model_manage_positions->update_position();

                if (is_numeric($result)) {
                    //search the position's updated info
                    $this->session->set_flashdata('msg', lang('updated_suc'));
                    redirect('/admin/manage_positions/edit_position/' . $position_id, 'location');
                } else {
                    $this->session->set_flashdata('error', lang('updated_failed'));
                    redirect('/admin/manage_positions/edit_position/' . $position_id, 'location');
                }
            }
        } else {// end of updating function
            if ($position_info) {
                //position found
                output_views('admin/manage_positions/view_edit_position', $position_info, 'dashboard');
            } else {
                //there is no position with that user id
                output_views('admin/manage_positions/view_edit_position', array('error' => '用户不存在！！'), 'dashboard');
            }
        }
    }

    public function delete_position($position_id = '') {
        //result will return TRUE OR FALSE
        $result = $this->model_manage_positions->delete_position($position_id);
        if ($result) {
            $this->session->set_flashdata('msg', lang('deleted_suc'));
            redirect('/admin/manage_positions', 'location');
        } else {
            $this->session->set_flashdata('error', lang('deleted_failed'));
            redirect('/admin/manage_positions', 'location');
        }
    }

    public function show_deleted_positions($offset=0) {
        
        //config the pagination
        $config['base_url'] = base_url() . 'admin/manage_positions/show_deleted_positions/';
        $config['total_rows'] = $this->db->get_where('positions', array('Status' => 'D'))->num_rows();
        $config['per_page'] = 20;
        $data['pagination'] = output_pagination($config);
        $data['type'] = "position"; //set it for the post/position header

        //return an array contains all published positions
        $data['deleted_positions_list'] = $this->model_manage_positions->find_all_deleted_positions($offset, $config['per_page']); //return an array contains all published positions
        output_views('admin/manage_positions/view_deleted_positions', $data, 'dashboard');
    }

    public function restore_position($position_id) {
        $result = $this->model_manage_positions->restore_position($position_id);
        if ($result) {
            $this->session->set_flashdata('msg', lang('restored_suc'));
            redirect('/admin/manage_positions/show_deleted_positions', 'location');
        } else {
            $this->session->set_flashdata('error', lang('restored_failed'));
            redirect('/admin/manage_positions/show_deleted_positions', 'location');
        }
    }

    public function perm_delete_position($position_id) {
        $result = $this->model_manage_positions->perm_delete_position($position_id);
        if ($result) {
            $this->session->set_flashdata('msg', lang('deleted_suc'));
            redirect('/admin/manage_positions/show_deleted_positions', 'location');
        } else {
            $this->session->set_flashdata('error', lang('deleted_failed'));
            redirect('/admin/manage_positions/show_deleted_positions', 'location');
        }
    }

}
