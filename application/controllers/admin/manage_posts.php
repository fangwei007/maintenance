<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manage_posts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!in_array($this->session->userdata('role'), $this->config->item('manage_posts'))) {
            redirect('/display_errors/authenticate_error', 'location');
        }
        $this->load->library('pagination');
        $this->load->model('model_manage_posts');
    }

    public function index() {
        $this->show_published_posts();
    }

    public function show_published_posts($offset = 0) {
        
        //config the pagination
        $config['base_url'] = base_url() . 'admin/manage_posts/show_published_posts/';
        $config['total_rows'] = $this->db->get_where('posts', array('Status !=' => 'D'))->num_rows();
        $config['per_page'] = 5;
        $config['uri_segment'] = 4;
        $data['pagination'] = output_pagination($config);
        $data['type'] = "position"; //set it for the post/position header

        //return an array contains all published posts
        $data['published_posts_list'] = $this->model_manage_posts->find_all_published_posts($offset, $config['per_page']); //return an array contains all published posts
        output_views('admin/manage_posts/view_published_posts', $data, 'dashboard');
    }

    public function review_videos($offset = 0){
        //config the pagination
        $config['base_url'] = base_url() . 'admin/manage_posts/review_videos/';
        $config['total_rows'] = $this->db->get_where('posts', array('Status' => 'R', 'Type' => 'video'))->num_rows();
        $config['per_page'] = 20;
        $data['pagination'] = output_pagination($config);

        //return an array contains all published posts
        $data['videos'] = $this->model_manage_posts->find_all_reviewing_videos($offset, $config['per_page']); //return an array contains all published posts
        output_views('admin/manage_posts/view_review_videos', $data, 'dashboard');
    }
//    public function add_post() {
//        if (isset($_POST['publish'])) {
//            $this->load->library('form_validation');
//
//            //rules of creation
//            $this->form_validation->set_rules('title', '标题', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('type', '类别', 'trim|max_length[20]|xss_clean');
//            $this->form_validation->set_rules('summary', '概要', 'required|xss_clean');
//            $this->form_validation->set_rules('content', '内容', 'required|xss_clean');
//
//            if ($this->form_validation->run() == FALSE) {
//                //user didn't validate, send back to add form and show errors
//                output_views('admin/manage_posts/view_add_post','', 'dashboard');
//            } else {
//                //result returns true or false
//                $result = $this->model_manage_posts->create_post();
//                if ($result === TRUE) {
//                    //saved sucessful
//                    $this->session->set_flashdata('msg', '发布成功！');
//                    redirect('/admin/manage_posts/', 'location');
//                } else {
//                    //saved failed
//                    if ($result) {
//                        $data['error'] = $result;
//                        output_views('admin/manage_posts/view_add_post', $data, 'dashboard');
//                    } else {
//                        $data['error'] = 'Add post failed';
//                        output_views('admin/manage_posts/view_add_post', $data, 'dashboard');
//                    }
//                }
//            }
//        } else {
//            output_views('admin/manage_posts/view_add_post','', 'dashboard');
//        }
//    }

    public function edit_post($post_id = '') {
        //return an array contains all post's info
        $post_info = $this->model_manage_posts->find_post_by_id($post_id);
        if (isset($_POST['publish'])) {
            $this->load->library('form_validation');

            //rules of updating
            $this->form_validation->set_rules('title', 'lang:title', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('type', 'lang:type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('category', 'lang:category', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content', 'lang:content', 'trim|required|xss_clean');
            if ($this->input->post('type') === 'video'){
                $this->form_validation->set_rules('video_link', 'lang:video_link', 'trim|required');
            }
            if ($this->input->post('type') === 'article' || $this->input->post('type') === 'event'){
                $this->form_validation->set_rules('summary', 'lang:summary', 'trim|required|max_length[200]|xss_clean');
            }

            if ($this->form_validation->run() == FALSE) {
                //user didn't validate, send back to edit form and show errors
                output_views('admin/manage_posts/view_edit_post', $post_info, 'dashboard');
            } else {
                //successful updated
                //check image existed or not
                $image = $post_info->Image;         
                $result = $this->model_manage_posts->update_post($image);

                if (is_numeric($result)) {
                    //search the post's updated info
                    $this->session->set_flashdata('msg', '修改成功！');
                    redirect('/admin/manage_posts/edit_post/' . $post_id, 'refresh');
                } elseif($result) {
                    //if there is a image uploading error
                    $this->session->set_flashdata('error', $result);
                    redirect('/admin/manage_posts/edit_post/' . $post_id, 'location');
                }else{
                    $this->session->set_flashdata('error', '修改失败！');
                    redirect('/admin/manage_posts/edit_post/' . $post_id, 'location');
                }
            }
        } else {// end of updating function
            output_views('admin/manage_posts/view_edit_post', $post_info, 'dashboard');
        }
    }

    public function delete_featured_image($post_id = ''){
        $result = $this->model_manage_posts->delete_post_image($post_id);
        if($result){
            redirect('/admin/manage_posts/edit_post/' . $post_id, 'location');
         }else{
            $this->session->set_flashdata('error', '删除图片失败');
            redirect('/admin/manage_posts/edit_post/' . $post_id, 'location');
         }
    }
    
    public function delete_post($post_id = '') {
        //result will return TRUE OR FALSE
        $result = $this->model_manage_posts->delete_post($post_id);
        if ($result) {
            $this->session->set_flashdata('msg', 'Post deleted successful');
            redirect('/admin/manage_posts', 'refresh');
        } else {
            $this->session->set_flashdata('msg', 'Deleted failed');
            redirect('/admin/manage_posts', 'refresh');
        }
    }

    public function show_deleted_posts($offset=0) {
        
        //config the pagination
        $config['base_url'] = base_url() . 'admin/manage_posts/show_deleted_posts/';
        $config['total_rows'] = $this->db->get_where('posts', array('Status' => 'D'))->num_rows();
        $config['per_page'] = 20;
        $data['pagination'] = output_pagination($config);
        $data['type'] = "position"; //set it for the post/position header

        //return an array contains all published posts
        $data['deleted_posts_list'] = $this->model_manage_posts->find_all_deleted_posts($offset, $config['per_page']); //return an array contains all published posts
        output_views('admin/manage_posts/view_deleted_posts', $data, 'dashboard');
    }

    public function restore_post($post_id) {
        $result = $this->model_manage_posts->restore_post($post_id);
        if ($result) {
            $this->session->set_flashdata('msg', '还原成功！');
            redirect('/admin/manage_posts/show_deleted_posts', 'refresh');
        } else {
            $this->session->set_flashdata('msg', '还原失败！');
            redirect('/admin/manage_posts/show_deleted_posts', 'refresh');
        }
    }

    public function perm_delete_post($post_id) {
        $result = $this->model_manage_posts->perm_delete_post($post_id);
        if ($result) {
            $this->session->set_flashdata('msg', '永久删除成功！');
            redirect('/admin/manage_posts/show_deleted_posts', 'refresh');
        } else {
            $this->session->set_flashdata('msg', '永久删除失败！');
            redirect('/admin/manage_posts/show_deleted_posts', 'refresh');
        }
    }

}
