<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_manage_posts extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('upload_image_helper');
    }

    public function find_post_by_id($post_id) {
        $result = $this->db->get_where('posts', array('PostID' => $post_id), 1);

        if ($result->num_rows() === 1) {
            return $result->row();
        } else {
            return FALSE;
        }
    }

    public function find_all_published_posts($start_row, $per_page) {
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('posts', array('Status !=' => 'D'), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_all_reviewing_videos($start_row, $per_page){
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('posts', array('Status' => 'R', 'Type' => 'video'), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    public function find_all_deleted_posts($start_row, $per_page) {
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('posts', array('Status' => 'D'), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

//    public function create_post() {
//
//         //set the image uploading field be an option
//        if (!empty($_FILES['featured_image']['name'])) {
//            $image_data = $this->upload_image('featured_image');
//        }
//        if(!isset($image_data['error'])){
//            //image uploaded successful or no upload
//            if(isset($image_data['file_name'])) {
//                $data['Image'] = $image_data['file_name'];
//            }
//            $data['Title'] = $this->input->post('title');
//            $data['Type'] = $this->input->post('type');
//            $data['Category'] = $this->input->post('category');
//            $data['VideoLink'] = $this->input->post('video_link');
//            $data['AuthorID'] = $this->session->userdata('user_id');
//            $data['Summary'] = $this->input->post('summary');
//            $data['Content'] = $this->input->post('content');
//            $data['CreatedOn'] = date('Y-m-d H:i:s', time());
//            $data['Level'] = $this->input->post('level');
//            $data['Status'] = 'A';
//
//            $this->db->insert('posts', $data);
//
//            if ($this->db->affected_rows() === 1) {
//                // inserted succesful
//                return 'success';
//            } else {
//                return FALSE;
//            }
//        }else{
//            //if there is a image upload error
//            return $image_data['error'];
//        }
//    }

    public function update_post($image) {
        $data['Type'] = $this->input->post('type');
        //set the image uploading field be an option if it's video
        if($data['Type'] === 'video'){
            if (!empty($_FILES['featured_image']['name'])) {
                $image_data = $this->upload_image('featured_image','video_image');
            }else{
                if(empty($image)){
                    $data['Image'] = $this->config->item('default_video_image');
                }
            }
        }else{
            if(empty($image)){
                $image_data = $this->upload_image('featured_image','post_image');
            }
        }
        if(!isset($image_data['error'])){
            //image uploaded successful or no upload
            if(isset($image_data['file_name'])) {
                $data['Image'] = $image_data['file_name'];
            }
            $post_id = $this->input->post('post_id');
            $data['Title'] = $this->input->post('title');
            $data['Summary'] = $this->input->post('summary');
            $data['Content'] = $this->input->post('content');
            $data['Category'] = $this->input->post('category');
            if($this->input->post('video_link')){$data['VideoLink'] = $this->input->post('video_link');}
            $data['UpdatedOn'] = date('Y-m-d H:i:s', time());
            $data['Level'] = $this->input->post('level');
            $data['Status'] = $this->input->post('status');
            //update the user info
            $this->db->where('PostID', $post_id)->update('posts', $data);
            if ($this->db->affected_rows() >= 0) {
                return $post_id;
            } else {
                return FALSE;
            }
        }else{
            //if there is a image upload error
            return $image_data['error'];
        }
    }
    
    public function delete_post($post_id) {
        $this->db->where('PostID', $post_id)->update('posts', array('Status' => 'D'));
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function restore_post($post_id) {
        $this->db->where('PostID', $post_id)->update('posts', array('Status' => 'A'));
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function perm_delete_post($post_id) {
        $this->db->delete('posts', array('PostID' => $post_id));
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function delete_post_image($post_id){
        $result = $this->db->limit(1)->select('Image')->get_where('posts', array('PostID'=>$post_id));
        if($result->num_rows() === 1){
            $row = $result->row();
            if (strpos($row->Image,'default') === false) {
                $file_path = array();
                $file_path[] = './assets/images/posts/' . $row->Image;
                $file_path[] = './assets/images/posts/' . insert_before_extension($row->Image, '_large');
                $file_path[] = './assets/images/posts/' . insert_before_extension($row->Image, '_medium');
                $file_path[] = './assets/images/posts/' . insert_before_extension($row->Image, '_small');
                foreach($file_path as $f){
                    if(file_exists($f))unlink ($f);
                }
            }

            //delete from posts table
            //$sql = "UPDATE posts SET FeaturedImageName = NULL WHERE PostId = {$post_id}";
            $this->db->where('PostID', $post_id)->update('posts', array('Image' => NULL));
            if($this->db->affected_rows() === 1){
                return TRUE;
            }else {
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }
    
    private function upload_image($file_field='', $type=''){
        $config['upload_path'] = $this->config->item('posts');
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['file_name']  = $this->session->userdata('user_id') . '_' .date('Y-m-d_H-i-s'); //create the temp file which name is userid_time
        $config['max_size']	= '1048'; //2MB
        $config['min_width']  = $this->config->item('min_post_image_width');
        $config['min_height']  = $this->config->item('min_post_image_height');
        $this->load->library('upload', $config);
//        $this->upload->initialize($config); // initialize method is used to accomplish the rename file function
        if($this->upload->do_upload($file_field)){
            $upload_data = $this->upload->data();
            $ratio = ($upload_data['image_width'] > $upload_data['image_height']) ? $upload_data['image_width']/$upload_data['image_height'] : $upload_data['image_height']/$upload_data['image_width'];
            //set the dim
            $dim = ($upload_data['image_width'] < $upload_data['image_height']) ? 'width' : 'height';
            if($type === 'video_image'){
                //resize the images with dif size
                $dim_s = $ratio <= 1.5 ? (($upload_data['image_width'] > $upload_data['image_height']) ? 'width' : 'height') : (($upload_data['image_width'] < $upload_data['image_height']) ? 'width' : 'height');
                $this->create_medium_image($upload_data['file_name'], $dim, $type);
                $this->create_small_image($upload_data['file_name'], $dim_s, $type);
            }else{
                //resize the images with dif size
                $this->create_large_image($upload_data['file_name'], 'width', $type);
                $this->create_medium_image($upload_data['file_name'], $dim, $type);
            }

            $info['file_name'] = $upload_data['file_name'];
            return $info;
        }else{
//            0: UPLOAD_ERR_OK
//            1: UPLOAD_ERR_INI_SIZE
//            2: UPLOAD_ERR_FORM_SIZE
//            3: UPLOAD_ERR_PARTIAL
//            4: UPLOAD_ERR_NO_FILE
//            6: UPLOAD_ERR_NO_TMP_DIR
//            7: UPLOAD_ERR_CANT_WRITE
//            8: UPLOAD_ERR_EXTENSION
            $info['error'] = $this->upload->display_errors('', '');
            return $info;
        }
    }
    
    private function create_large_image($image_name, $dim, $type){
        $config['source_image'] = $this->config->item('posts') . $image_name;
        $config['new_image'] = $this->config->item('posts') . insert_before_extension($image_name, '_large');
        $config['width'] = $this->config->item('large_' . $type . '_width');
        $config['height'] = $this->config->item('large_' . $type . '_height');
        $config['master_dim'] = $dim;
        return generate_image($config);
    }
    private function create_medium_image($image_name, $master_dim, $type){
        $config['source_image'] = $this->config->item('posts') . $image_name;
        $config['new_image'] = $this->config->item('posts') . insert_before_extension($image_name, '_medium');
        $config['width'] = $this->config->item('medium_' . $type . '_width');
        $config['height'] = $this->config->item('medium_' . $type . '_height');
        $config['master_dim'] = $master_dim;
        return generate_image($config);
    }
    
    private function create_small_image($image_name,$master_dim, $type){
        $config['source_image'] = $this->config->item('posts') . $image_name;
        $config['new_image'] = $this->config->item('posts') . insert_before_extension($image_name, '_small');
        $config['width'] = $this->config->item('small_' . $type . '_width');
        $config['height'] = $this->config->item('small_' . $type . '_height');
        $config['master_dim'] = $master_dim;
        return generate_image($config);
    }
    

}
