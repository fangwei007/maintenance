<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_account extends CI_Controller {
    private $cur_user_id, $cur_user_role;
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('/display_errors/login_error', 'location');
        }
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->model('model_my_account');
        $this->cur_user_id = $this->session->userdata('user_id');
        $this->cur_user_role = $this->session->userdata('role');
    }

    public function index() {
        if(get_user_session('status') === 'V'){
            $this->show_published_posts();
        }else{
            $this->edit_my_profile();
        }
    }

    public function show_published_posts($offset=0) {
        //config the pagination
        $config['base_url'] = base_url() . 'my_account/show_published_posts/';
        $config['total_rows'] = $this->db->get_where('posts', array('Status' => 'A', 'AuthorID'=>$this->cur_user_id))->num_rows();
        $config['per_page'] = 10;
        $data['pagination'] = output_pagination($config);
        $data['type'] = "post"; //set it for the post/position header
        
        //return an array contains all published posts
        $data['published_posts_list'] = $this->model_my_account->find_all_published_posts($config['per_page'], $offset); //return an array contains all published posts
        output_views('my_account/view_published_posts', $data, 'my_account');
    }

    public function show_deleted_posts($offset=0) {
        //config the pagination
        $config['base_url'] = base_url() . 'my_account/show_deleted_posts/';
        $config['total_rows'] = $this->db->get_where('posts', array('Status' => 'D', 'AuthorID'=>$this->cur_user_id))->num_rows();
        $config['per_page'] = 10;
        $data['pagination'] = output_pagination($config);
        $data['type'] = "post"; //set it for the post/position header
        
        //return an array contains all published posts
        $data['deleted_posts_list'] = $this->model_my_account->find_all_deleted_posts($config['per_page'], $offset); //return an array contains all published posts
        output_views('my_account/view_deleted_posts', $data, 'my_account');
    }
    
    public function add_post() {
        $data['type'] = "post";
        if (isset($_POST['publish'])) {

            //rules of creation
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
                //user didn't validate, send back to add form and show errors
                output_views('my_account/view_add_post',$data, 'my_account');
            } else {
                //result returns true or false
                $result = $this->model_my_account->create_post();
                if ($result === 'success') {
                    //saved sucessful
                    $this->session->set_flashdata('msg', '发布成功！');
                    redirect('/my_account/show_published_posts', 'location');
                } else {
                    //saved failed
                    if ($result) {
                        $data['error'] = $result;
                        output_views('my_account/view_add_post', $data, 'my_account');
                    } else {
                        $data['error'] = lang('post_failed');
                        output_views('my_account/view_add_post', $data, 'my_account');
                    }
                }
            }
        } else {
            output_views('my_account/view_add_post',$data,'my_account');
        }
    }

    public function edit_post($post_id = '') {
        //return an array contains all post's info
        $post_info = $this->model_my_account->find_post_by_id($post_id);
        $post_info->type = "post";
        if($post_info->AuthorID != $this->cur_user_id){
            redirect('/display_errors/post_error', 'location');
        }
        if (isset($_POST['publish'])) {

            //rules of updating
            $this->form_validation->set_rules('title', 'lang:title', 'trim|required|max_length[100]|xss_clean');
//            $this->form_validation->set_rules('type', 'lang:type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('category', 'lang:category', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content', 'lang:content', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('video_link', 'lang:video_link', 'trim|required');
            if ($this->input->post('type') === 'article' || $this->input->post('type') === 'event'){
                $this->form_validation->set_rules('summary', 'lang:summary', 'trim|required|max_length[200]|xss_clean');
            }

            if ($this->form_validation->run() == FALSE) {
                //user didn't validate, send back to edit form and show errors
                output_views('my_account/view_edit_post', $post_info, 'my_account');
            } else {
                //successful updated
                //check image existed or not
                $image = $post_info->Image;
                //return the updated post's id           
                $result = $this->model_my_account->update_post($image);

                if (is_numeric($result)) {
                    //search the post's updated info
                    $this->session->set_flashdata('msg', '修改成功！');
                    redirect('/my_account/edit_post/' . $post_id, 'location');
                } elseif($result) {
                    //if there is a image uploading error
                    $this->session->set_flashdata('error', $result);
                    redirect('/my_account/edit_post/' . $post_id, 'location');
                }else{
                    $this->session->set_flashdata('error', '修改失败！');
                    redirect('/my_account/edit_post/' . $post_id, 'location');
                }
            }
        } else {// end of updating function
            output_views('my_account/view_edit_post', $post_info, 'my_account');
        }
    }
    
    public function edit_my_profile(){
        $client_info = $this->model_my_account->find_user_info_by_id($this->cur_user_id);//return an array contains all clients' info
        $client_info->type = "profile";
        if(isset($_POST['update'])){
            //rules of updating
            $this->form_validation->set_rules('nickname', '显示名字', 'trim|required|no_special_character|is_existed[user_meta.Nickname.'.$this->cur_user_id .']|max_length[20]|xss_clean');
            $this->form_validation->set_rules('phone', '联系电话', 'trim|max_length[20]|xss_clean');
            $this->form_validation->set_rules('city', '城市', 'trim|max_length[20]|xss_clean');
            $this->form_validation->set_rules('biography', '简介', 'trim|max_length[1000]|xss_clean');
            //school or industry have to file the website and name
            if($this->cur_user_role === 'school' || $this->cur_user_role === 'industry'){
                $this->form_validation->set_rules('website', 'lang:website', 'trim|required|valid_url|max_length[200]|xss_clean');
                $this->form_validation->set_rules('name', '真实姓名', 'trim|required|max_length[40]|xss_clean');
            }else{
                $this->form_validation->set_rules('website', 'lang:website', 'trim|valid_url|max_length[200]|xss_clean');
                $this->form_validation->set_rules('name', '真实姓名', 'trim|max_length[40]|xss_clean');
            }   

            if($this->form_validation->run() == FALSE){
                //user didn't validate, send back to edit form and show errors
                output_views('my_account/view_edit_my_profile', $client_info,'my_account');
            }else{
                //successful updated
                //return the updated user's id           
                $result = $this->model_my_account->update_my_profile($this->cur_user_id);
                switch ($result) {
                    case 'update_success':
                        $this->session->set_flashdata('msg', lang('updated_suc'));
                        redirect('/my_account/edit_my_profile/', 'location');
                        break;
                    case 'user_history_error':
                        $this->session->set_flashdata('error', '用户历史记录更新失败');
                        redirect('/my_account/edit_my_profile/', 'location');
                        break;
                    default:
                        $this->session->set_flashdata('error', lang('no_changed'));
                        redirect('/my_account/edit_my_profile/', 'location');
                        break;
                }                
            }
        }else{// end of updating function
            output_views('my_account/view_edit_my_profile', $client_info ,'my_account');
        }
    }

    public function change_pass(){
        $data["type"] = "profile";
        if(isset($_POST['update'])) {
            //first check if its a valid password or not
            $this->form_validation->set_rules('old_password', '旧密码', 'trim|required|min_length[6]|max_length[30]');
            $this->form_validation->set_rules('new_password', '新密码', 'trim|required|min_length[6]|max_length[30]|matches[new_password_conf]|xss_clean');
            $this->form_validation->set_rules('new_password_conf', '再次输入新密码', 'trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE) {
                output_views('my_account/view_change_password','' , 'my_account');
            }else {
                $result = $this->model_my_account->check_update_password();
                
                switch($result) {
                case 'update_success':
                    //updating complete, show the success message
                    $this->session->set_flashdata('msg', '密码修改成功');
                    redirect('/my_account/change_pass', 'location');
                    break;
                case 'incorrect_password':
                    $this->session->set_flashdata('error', '旧密码错误');
                    redirect('/my_account/change_pass', 'location');
                    break;
                default :
                    //return FALSE
                    $this->session->set_flashdata('error', '密码更新失败');
                    redirect('/my_account/change_pass', 'location');
                    break;
                }
            }
        }else {
            output_views('my_account/view_change_password',$data,'my_account');
        }
    }
    
    public function change_avatar(){
        $data["type"] = "profile";
        if(isset($_FILES['my_avatar'])) {
            $result = $this->model_my_account->update_avatar();
            if(!empty($result['error'])){
                $this->session->set_flashdata('error', $result['error']);
                redirect('/my_account/change_avatar', 'location');
            }else{
                //if uploaded successful
                output_views('my_account/view_crop_avatar', $result, 'my_account');
            }

            
        }else{
            $data['avatar'] = $this->model_my_account->find_user_avatar();//return an array contains all clients' info
            output_views('my_account/view_change_avatar', $data, 'my_account');
        }
    }
    
    public function crop_avatar(){
        if(isset($_POST['avatar_x']) && isset($_POST['avatar_y'])){
            $result = $this->model_my_account->crop_avatar();
            if(!empty($result['error'])){
                $this->session->set_flashdata('error', $result['error']);
                redirect('/my_account/change_avatar', 'location');
            }else{
                //if crop successful
                $this->session->set_flashdata('msg', '更新成功！');
                redirect('/my_account/change_avatar', 'location');
            }
        }
    }
    
    public function delete_featured_image($post_id = ''){
        if(!$this->check_vali_post_id($post_id)){
             redirect('/display_errors/post_error', 'location');
        }
        $result = $this->model_my_account->delete_post_image($post_id);
        if($result){
            redirect('/my_account/edit_post/' . $post_id, 'location');
         }else{
            $this->session->set_flashdata('error', '删除图片失败');
            redirect('/my_account/edit_post/' . $post_id, 'location');
         }
    }
    
    public function delete_post($post_id = '') {
        if(!$this->check_vali_post_id($post_id)){
             redirect('/display_errors/post_error', 'location');
        }
        //result will return TRUE OR FALSE
        $result = $this->model_my_account->delete_post($post_id);
        if ($result) {
            $this->session->set_flashdata('msg', '删除成功');
            redirect('/my_account', 'location');
        } else {
            $this->session->set_flashdata('error', '删除失败');
            redirect('/my_account', 'location');
        }
    }
    
    public function restore_post($post_id) {
        if(!$this->check_vali_post_id($post_id)){
             redirect('/display_errors/post_error', 'location');
        }
        $result = $this->model_my_account->restore_post($post_id);
         if ($result) {
             $this->session->set_flashdata('msg', '还原成功！');
             redirect('/my_account/show_deleted_posts', 'location');
         } else {
             $this->session->set_flashdata('error', '还原失败！');
             redirect('/my_account/show_deleted_posts', 'location');
         }
    }
    
    public function perm_delete_post($post_id) {
        if(!$this->check_vali_post_id($post_id)){
             redirect('/display_errors/post_error', 'location');
        }
        $result = $this->model_my_account->perm_delete_post($post_id);
         if ($result) {
             $this->session->set_flashdata('msg', '永久删除成功！');
             redirect('/my_account/show_deleted_posts', 'location');
         } else {
             $this->session->set_flashdata('error', '永久删除失败！');
             redirect('/my_account/show_deleted_posts', 'location');
         }
    }
    
    public function activate_account() {
        if(isset($_POST['submit'])){
            $this->form_validation->set_rules('email', '邮箱', 'trim|required|valid_email|xss_clean');
            if($this->form_validation->run() == FALSE) {
                output_views('my_account/view_resend_vali_email');
            }else{
                //initial checks on data are ok, now check if they are valid credentials or not
                $result = $this->model_my_account->resend_vali_email();

                switch($result) {
                    case 'sent':
                        //sent email successfully
                        setcookie('resend_email', 'no', time()+60, '/'); //users cannot resend validation email in 60 secs
                        $this->session->set_flashdata('msg', lang('vali_email_sent'));
                        redirect('my_account/activate_account', 'location');
                        break;
                    case 'activated':
                        //email already has been activated
                        $this->session->set_flashdata('error', lang('already_activated'));
                        redirect('my_account/activate_account', 'location');
                        break;
                    case 'not_available':
                        //email has been deleted or suspended
                        $this->session->set_flashdata('error', lang('email_not_available'));
                        redirect('my_account/activate_account', 'location');
                        break;
                    default :
                        //email cannot be found
                        $this->session->set_flashdata('error', lang('email_not_existed'));
                        redirect('my_account/activate_account', 'location');
                        break;
                }
            }
        }else{
            output_views('my_account/view_resend_vali_email');
        }
    }
    
    
    private function check_vali_post_id($post_id){
        $post_array = $this->model_my_account->find_post_by_id($post_id);
        //return TRUE if post_id is valid
        return ($post_array->AuthorID === $this->cur_user_id);
    }

    public function my_following($offset=0){
        //config the pagination
        $config['base_url'] = base_url() . 'my_account/my_following/';
        $config['total_rows'] = $this->db->get_where('follow_users', array('FollowerID' => $this->cur_user_id))->num_rows();
        $config['per_page'] = $this->config->item('users_per_page');
        $data['pagination'] = output_pagination($config);
        $data['type'] = "follow";
        $data['my_following'] = $this->model_my_account->find_my_following_users($config['per_page'], $offset);
        output_views('my_account/view_my_following', $data, 'my_account');
    }
    
    public function my_followers($offset=0){
        //config the pagination
        $config['base_url'] = base_url() . 'my_account/my_followers/';
        $config['total_rows'] = $this->db->get_where('follow_users', array('UserID' => $this->cur_user_id))->num_rows();
        $config['per_page'] = $this->config->item('users_per_page');
        $data['pagination'] = output_pagination($config);
        $data['type'] = "follow";
        $data['my_followers'] = $this->model_my_account->find_my_followers($config['per_page'], $offset);
        output_views('my_account/view_my_followers', $data, 'my_account');
    }

    public function my_comments($source='others', $offset=0){
        //config the pagination
        $config['base_url'] = base_url() . 'my_account/my_comments/' . $source .'/';
        $config['per_page'] = $this->config->item('my_comments_per_page');
        $config['uri_segment'] = 4;
        switch ($source) {            
            case 'others': //if comments is from my others' posts
                $config['total_rows'] = $this->db->get_where('comments', array('InsertUserID' => $this->cur_user_id))->num_rows();
                break;
            
            case 'reply': //someone replyed my comments
                $config['total_rows'] = $this->db->get_where('comments', array('ReplyToUser' => $this->cur_user_id))->num_rows();
                break;

            default:
                $config['total_rows'] = 0;
                break;
        }
        
        $data['pagination'] = output_pagination($config);
        $data['type'] = "comment";
        $data['comments'] = $this->model_my_account->find_my_comments($source, $config['per_page'], $offset);
        $data['source'] = $source;
        output_views('my_account/view_my_comments', $data, 'my_account');
    }
    
    /*
     * Author: Wei Fang
     * Date: Mar. 9th
     * Function: 显示收藏列表
     */
    public function my_watch_list_posts($offset=0) {
        //config the pagination
        $config['base_url'] = base_url() . 'my_account/my_watch_list_posts/';
        $config['total_rows'] = $this->db->get_where('watch_lists', array('UserID' => $this->cur_user_id, 'PostType' => 'post'))->num_rows();
        $config['per_page'] = 12;
        $data['pagination'] = output_pagination($config);
        $data['type'] = "stow";
        $data['my_watch_list_posts'] = $this->model_my_account->find_my_watch_list_posts($config['per_page'], $offset);
        output_views('my_account/view_my_watch_list_post', $data, 'my_account');
    }
    
    public function my_watch_list_positions($offset=0) {
        //config the pagination
        $config['base_url'] = base_url() . 'my_account/my_watch_list_positions/';
        $config['total_rows'] = $this->db->get_where('watch_lists', array('UserID' => $this->cur_user_id, 'PostType' => 'position'))->num_rows();
        $config['per_page'] = 12;
        $data['pagination'] = output_pagination($config);
        $data['type'] = "stow";
        $data['my_watch_list_positions'] = $this->model_my_account->find_my_watch_list_positions($config['per_page'], $offset);
        output_views('my_account/view_my_watch_list_position', $data, 'my_account');
    }
    
    
    /*
     * Author: Wei
     * Date : 3.30
     */

    public function apply_official() {
        //return an array contains all clients' info
        $client_info = $this->model_my_account->find_user_all_info_by_id();
        $client_info['type'] = "profile";
        if ($verify_info = $this->model_my_account->find_verify_info()) {
            $client_info['status'] = $verify_info->VerifyStatus;
            $client_info['note'] = $verify_info->Note;
            $client_info['feedback'] = $verify_info->Feedback;
        }
//        print_r($client_info);
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('application', '申请', 'trim|max_length[500]|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                output_views('my_account/view_apply_official', $client_info, 'my_account');
            } else {
                //initial checks on data are ok, now check if they are valid credentials or not
                $result = $this->model_my_account->insert_verify_application($_POST['application']);
                switch ($result) {
                    case 'sent':
                        $this->session->set_flashdata('msg', '申请信息已发送，待审核中...');
                        redirect('my_account/apply_official', 'location');
                        break;
                    case 'user_info_incomplete':
                        $this->session->set_flashdata('error', '用户信息不完整或错误，申请失败');
                        redirect('my_account/apply_official', 'location');
                        break;
                    case 'not_activate':
                        $this->session->set_flashdata('error', '用户未激活，无法申请');
                        redirect('my_account/apply_official', 'location');
                        break;
                    default :
                        $this->session->set_flashdata('error', '未知错误');
                        redirect('my_account/apply_official', 'location');
                        break;
                }
            }
        } else if (isset($_POST['update'])) {
            $this->form_validation->set_rules('application', '申请', 'trim|max_length[500]|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                output_views('my_account/view_apply_official', $client_info, 'my_account');
            } else {
                //initial checks on data are ok, now check if they are valid credentials or not
                $result = $this->model_my_account->update_verify_application($_POST['application']);
                switch ($result) {
                    case 'success':
                        $this->session->set_flashdata('msg', '申请信息已更新!');
                        redirect('my_account/apply_official', 'location');
                        break;
                    case 'fail':
                        $this->session->set_flashdata('error', '申请信息更新失败！');
                        redirect('my_account/apply_official', 'location');
                        break;
                    default :
                        $this->session->set_flashdata('error', '未知错误');
                        redirect('my_account/apply_official', 'location');
                        break;
                }
            }
        } else {
            output_views('my_account/view_apply_official', $client_info, 'my_account');
        }
    }
    
    //-------------------------------------*** Below are functions for positions ***--------------------------
    public function show_published_positions($offset=0) {
        //config the pagination
        $config['base_url'] = base_url() . 'my_account/show_published_positions/';
        $config['total_rows'] = $this->db->get_where('positions', array('Status' => 'A', 'AuthorID'=>$this->cur_user_id))->num_rows();
        $config['per_page'] = 10;
        $data['pagination'] = output_pagination($config);
        $data['type'] = "position"; //set it for the post/position header

        //return an array contains all published positions
        $data['published_positions_list'] = $this->model_my_account->find_all_published_positions($config['per_page'], $offset); //return an array contains all published positions
        output_views('my_account/view_published_positions', $data, 'my_account');
    }

    public function show_deleted_positions($offset=0) {
        //config the pagination
        $config['base_url'] = base_url() . 'my_account/show_deleted_positions/';
        $config['total_rows'] = $this->db->get_where('positions', array('Status' => 'D', 'AuthorID'=>$this->cur_user_id))->num_rows();
        $config['per_page'] = 10;
        $data['pagination'] = output_pagination($config);
        $data['type'] = "position"; //set it for the post/position header

        //return an array contains all published positions
        $data['deleted_positions_list'] = $this->model_my_account->find_all_deleted_positions($config['per_page'], $offset); //return an array contains all published positions
        output_views('my_account/view_deleted_positions', $data, 'my_account');
    }
    
    public function add_position() {
        $data['type'] = "position";
        if (isset($_POST['publish'])) {

            //rules of creation
            $this->form_validation->set_rules('title', 'lang:title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('field', 'lang:field', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'lang:country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('job_type', 'lang:job_type', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('expired_on', 'lang:expired_on', 'trim|required|xss_clean');
            $this->form_validation->set_rules('description', 'lang:description', 'trim|required|xss_clean');
            
            if ($this->form_validation->run() == FALSE) {
                //user didn't validate, send back to add form and show errors
                output_views('my_account/view_add_position','', 'my_account');
            } else {
                //result returns true or false
                $result = $this->model_my_account->create_position();
                if ($result === 'success') {
                    //saved sucessful
                    $this->session->set_flashdata('msg', '发布成功！');
                    redirect('/my_account/show_published_positions', 'location');
                } else {
                    //saved failed
                    if ($result) {
                        $data['error'] = $result;
                        output_views('my_account/view_add_position', $data, 'my_account');
                    } else {
                        $data['error'] = lang('position_failed');
                        output_views('my_account/view_add_position', $data, 'my_account');
                    }
                }
            }
        } else {
            output_views('my_account/view_add_position',$data,'my_account');
        }
    }
    
    public function edit_position($position_id = '') {
        $position_info = $this->model_my_account->find_position_by_id($position_id);
        $position_info->type = "position";
        if ($position_info->AuthorID != $this->cur_user_id) { //if the position doesn't belong to current user
            redirect('/display_errors/post_error', 'location');
        }
        if (isset($_POST['publish'])) {

            //rules of updating
            $this->form_validation->set_rules('title', 'lang:title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('field', 'lang:field', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'lang:country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('job_type', 'lang:job_type', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('expired_on', 'lang:expired_on', 'trim|required|xss_clean');
            $this->form_validation->set_rules('description', 'lang:description', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //user didn't validate, send back to edit form and show errors
                output_views('my_account/view_edit_position', $position_info, 'my_account');
            } else {
                $result = $this->model_my_account->update_position();
                if($result){
                    $this->session->set_flashdata('msg', '修改成功！');
                    redirect('/my_account/edit_position/' . $position_id, 'location');
                }else{
                    $this->session->set_flashdata('error', '修改失败！');
                    redirect('/my_account/edit_position/' . $position_id, 'location');
                }
            }
        } else {// end of updating function
            output_views('my_account/view_edit_position', $position_info, 'my_account');
        }
    }
    
    public function delete_position($position_id = '') {
        if (!$this->check_vali_position_id($position_id)) {
            redirect('/display_errors/post_error', 'location');
        }
        //result will return TRUE OR FALSE
        $result = $this->model_my_account->delete_position($position_id);
        if ($result) {
            $this->session->set_flashdata('msg', '删除成功');
            redirect('/my_account/show_published_positions', 'location');
        } else {
            $this->session->set_flashdata('error', '删除失败');
            redirect('/my_account/show_published_positions', 'location');
        }
    }

    public function restore_position($position_id) {
        if (!$this->check_vali_position_id($position_id)) {
            redirect('/display_errors/post_error', 'location');
        }
        $result = $this->model_my_account->restore_position($position_id);
        if ($result) {
            $this->session->set_flashdata('msg', '还原成功！');
            redirect('/my_account/show_deleted_positions', 'location');
        } else {
            $this->session->set_flashdata('error', '还原失败！');
            redirect('/my_account/show_deleted_positions', 'location');
        }
    }

    public function perm_delete_position($position_id) {
        if (!$this->check_vali_position_id($position_id)) {
            redirect('/display_errors/post_error', 'location');
        }
        $result = $this->model_my_account->perm_delete_position($position_id);
        if ($result) {
            $this->session->set_flashdata('msg', '永久删除成功！');
            redirect('/my_account/show_deleted_positions', 'location');
        } else {
            $this->session->set_flashdata('error', '永久删除失败！');
            redirect('/my_account/show_deleted_positions', 'location');
        }
    }
    
    private function check_vali_position_id($position_id) {
        $position_array = $this->model_my_account->find_position_by_id($position_id);
        //return TRUE if position_id is valid
        return ($position_array->AuthorID === $this->cur_user_id);
    }
    
    
    

    
}
