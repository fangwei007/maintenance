<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_my_account extends CI_Model {
    private $cur_user_id;
    function __construct() {
        parent::__construct();
        $this->cur_user_id = $this->session->userdata('user_id');
        $this->load->helper('upload_image_helper');
    }

    public function find_user_info_by_id($user_id){
        //find user's info from users table
        $user_result = $this->db->get_where('users', array('UserId' => $user_id), 1);
        if($user_result->num_rows() === 1){
            $row = $user_result->row();
            //find user's info from user_meta table
            $meta_result = $this->db->get_where('user_meta', array('UserId' => $user_id), 1);
            if($meta_result->num_rows() === 1){
                //insert the email to the meta array
                $meta_row = $meta_result->row();
                $meta_row->Email = $row->Email;
                return $meta_row;
            }else{
                return FALSE;
            }
        }else {
            return FALSE;
        }
    }
    
    public function find_users_tb_by_id($user_id){
        $result = $this->db->get_where('users', array('UserID' => $user_id), 1);

        if ($result->num_rows() === 1) {
            return $result->row();
        } else {
            return FALSE;
        }
    }
    
    public function find_user_meta_tb_by_id($user_id){
        $result = $this->db->get_where('user_meta', array('UserID' => $user_id), 1);

        if ($result->num_rows() === 1) {
            return $result->row();
        } else {
            return FALSE;
        }
    }
    
    public function find_user_avatar(){
        $result = $this->db->select('Avatar')->get_where('user_meta', array('UserID' => $this->cur_user_id));
        if($result->num_rows() === 1){
            $row = $result->row();
            return !empty($row->Avatar) ? $row->Avatar : 'default_avatar.jpg';
        }else {
            return FALSE;
        }
    }
    
    public function find_post_by_id($post_id) {
        $result = $this->db->get_where('posts', array('PostID' => $post_id), 1);

        if ($result->num_rows() === 1) {
            return $result->row();
        } else {
            return FALSE;
        }
    }

    public function find_all_published_posts($per_page, $start_row) {
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('posts', array('Status !=' => 'D', 'AuthorID'=>$this->cur_user_id), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    public function find_all_deleted_posts($per_page, $start_row) {
//        $sql = "SELECT * FROM posts WHERE Status = 'published' ORDER BY CreatedOn DESC LIMIT {$start_row},{$per_page}";
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('posts', array('Status' => 'D', 'AuthorID'=>$this->cur_user_id), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    public function find_my_following_users($per_page, $start_row){
        $this->db->join('user_meta', 'user_meta.UserID = follow_users.UserID');
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('follow_users', array('FollowerID' => $this->cur_user_id), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    public function find_my_followers($per_page, $start_row){
        $this->db->join('user_meta', 'user_meta.UserID = follow_users.UserID');
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('follow_users', array('follow_users.UserID' => $this->cur_user_id), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    /*
     * Author: Wei Fang
     * Date: Mar. 9th
     */
    public function find_my_watch_list_posts($per_page, $start_row){
        $this->db->join('posts', "posts.PostID = watch_lists.PostID");
        $result = $this->db->order_by("watch_lists.CreatedOn", "desc")->get_where('watch_lists', array('watch_lists.UserID' => $this->cur_user_id, 'watch_lists.PostType' => 'post'), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    public function find_my_watch_list_positions($per_page, $start_row){
        $this->db->join('positions', "positions.PositionID = watch_lists.PostID");
        $result = $this->db->order_by("watch_lists.CreatedOn", "desc")->get_where('watch_lists', array('watch_lists.UserID' => $this->cur_user_id, 'watch_lists.PostType' => 'position'), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    public function find_my_comments($source, $per_page, $start_row){
        switch ($source) {           
            case 'others': //if comments is from my others' posts
                $result = $this->db->order_by("InsertDate", "desc")->get_where('comments', array('InsertUserID' => $this->cur_user_id), $per_page, $start_row);
                if ($result->num_rows() > 0) {
                    $com_array = $result->result_array();
                    for($i=0; $i<count($com_array); $i++){
                        //add post's title into the array
                        $com_array[$i]['PostTitle'] = $this->find_post_title_by_post_id($com_array[$i]['PostID'], $com_array[$i]['PostType']);
                    }
                    return $com_array;
                } else {
                    return FALSE;
                }
                break;
            case 'reply': //someone replyed my comments
                $result = $this->db->order_by("InsertDate", "desc")->get_where('comments', array('ReplyToUser' => $this->cur_user_id), $per_page, $start_row);
                if ($result->num_rows() > 0) {
                    $com_array = $result->result_array();
                    for($i=0; $i<count($com_array); $i++){
                        //add post's title and comment author name into the array
                        $com_array[$i]['PostTitle'] = $this->find_post_title_by_post_id($com_array[$i]['PostID'], $com_array[$i]['PostType']);
                        $com_array[$i]['Replyer'] = $this->find_nickname_by_user_id($com_array[$i]['InsertUserID']);
                    }
                    return $com_array;
                } else {
                    return FALSE;
                }
                break;
            default:
                $result = FALSE;
                break;
        }
            
    }
    
    private function find_post_title_by_post_id($post_id, $post_type){
        if($post_type === 'post'){
            $result = $this->db->select('Title')->get_where('posts', array('PostID'=>$post_id), 1);
            if ($result->num_rows() === 1) {
                return $result->row()->Title;
            } else {
                return FALSE;
            }
        }elseif($post_type === 'position'){
            $result = $this->db->select('Title')->get_where('positions', array('PositionID'=>$post_id), 1);
            if ($result->num_rows() === 1) {
                return $result->row()->Title;
            } else {
                return FALSE;
            }
        }
    }

    private function find_nickname_by_user_id($user_id){
        $result = $this->db->select('Nickname')->get_where('user_meta', array('UserID'=>$user_id), 1);
        if ($result->num_rows() === 1) {
            return $result->row()->Nickname;
        } else {
            return FALSE;
        }
    }
    
    public function create_post() {
        $data['Type'] = $this->input->post('type');
        //set the image uploading field be an option if it's video or position
        if($data['Type'] === 'video'){
            if (!empty($_FILES['featured_image']['name'])) {//if uploaded image
                $image_data = $this->upload_image('featured_image','video_image');
            }else{
                $data['Image'] = $this->config->item('default_video_image');
            }
        }else{
            $image_data = $this->upload_image('featured_image','post_image');
        }
        if(!isset($image_data['error'])){
            //image uploaded successful or no upload
            if(isset($image_data['file_name'])) {
                $data['Image'] = $image_data['file_name'];
            }
            $data['Title'] = $this->input->post('title');
            $data['Category'] = $this->input->post('category');
            $data['VideoLink'] = $this->input->post('video_link');
            $data['AuthorID'] = $this->session->userdata('user_id');
            $data['Summary'] = $this->input->post('summary');
            $data['Content'] = $this->input->post('content');
            $data['CreatedOn'] = date('Y-m-d H:i:s', time());
            if($data['Type'] === 'video'){
                $data['Status'] = 'R';
                $data['Level'] = 1;
            }else{
                $data['Status'] = 'A';
                $data['Level'] = $this->config->item('default_post_level');
            }

            $this->db->insert('posts', $data);

            if ($this->db->affected_rows() === 1) {
                // inserted succesful
                return 'success';
            } else {
                return FALSE;
            }
        }else{
            //if there is a image upload error
            return $image_data['error'];
        }
    }

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

    public function update_my_profile(){
        $data['Name'] = $this->input->post('name');
        $data['Nickname'] = $this->input->post('nickname');
        $data['Phone'] = $this->input->post('phone');
        $data['City'] = $this->input->post('city');
        $data['Country'] = $this->input->post('country');
        $data['State'] = $this->input->post('state');
        $data['Website'] = $this->input->post('website');
        $data['Biography'] = $this->input->post('bio');
        
        //get the current data to create the $history with updated data
        $his_result = $this->db->get_where('user_meta', array('UserID'=>$this->cur_user_id),1);
        $older_userdata = $his_result->row();
        //create the history column in user history table
        $history = "";
        if(isset($older_userdata)){
            foreach($data as $column_name=>$value){
                if($older_userdata->$column_name != $value){
                    $history .= "Update " . $column_name . " from " . $older_userdata->$column_name . " to " . $value . "; ";
                }
            }
        }
        
        //update the user info
        $this->db->where('UserID', $this->cur_user_id);
        $this->db->update('user_meta', $data);
        if($this->db->affected_rows() === 1) {
            $msg = 'update_success';
        
            //insert updated info into user_history table
            $result = $this->insert_user_history($this->cur_user_id, $this->cur_user_id, $history);
            if(!$result){$msg = "user_history_error";}

            //set the nickname to session if user chose
            $this->session->set_userdata('nickname', $data['Nickname']);

            return $msg;
        }else {
            return FALSE;
        }
    }
    
    public function update_avatar(){
        $config['upload_path'] = $this->config->item('user_avatar');
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['file_name']  = $this->session->userdata('user_id') . '_' .date('Y-m-d_H-i-s'); //create the temp file which name is userid_time
        $config['max_size'] = '1048'; //1MB
        $config['max_filename']  = '50';
        $config['min_width']  = '170';
        $config['min_height']  = '170';

        $this->load->library('upload', $config);
        if($this->upload->do_upload('my_avatar')){
            $upload_data = $this->upload->data();
            //if ratio is too big, return error and delete the uploaded avatar
            $ratio = ($upload_data['image_width'] > $upload_data['image_height']) ? $upload_data['image_width']/$upload_data['image_height'] : $upload_data['image_height']/$upload_data['image_width'];
            if($ratio > 4){
                $this->model_my_account->unlink_user_photo($upload_data['file_name']);
                $info['error'] = "图片的长宽比太大！";
            }else{
                //resize the image if it's bigger than the defined size
                if($upload_data['image_width'] > $this->config->item('crop_avatar') || $upload_data['image_height'] > $this->config->item('crop_avatar')){
                    $result = $this->resize_to_crop_avatar($upload_data['file_name']);
                    $info['error'] = !empty($result['error']) ? $result['error'] : '';
                    $info['file_name'] = !empty($result['file_name']) ? $result['file_name'] : '';
                }else{
                    $info['file_name'] = $upload_data['file_name']; // userid_time.ext
                }
            }
        }else{
            $info['error'] = $this->upload->display_errors('', '');
        }
        
        return $info;
    }
    
    public function unlink_user_photo($photo){
        $photo = str_replace('_crop', '', $photo);
        $file_path = $this->config->item('user_avatar') . $photo;
        unlink($file_path);
        //check the image_crop exists before remove it
        $image_crop_path = $this->config->item('user_avatar') . insert_before_extension($photo, '_crop');
        if(file_exists($image_crop_path)){
            unlink($image_crop_path);
        }
    }
    
    public function crop_avatar(){
        $ori_name = str_replace('_crop', '', $_POST['crop_avatar_name']);
        $large_image_name = insert_before_extension($ori_name, '_large');
        $config['source_image'] = $this->config->item('user_avatar') . $_POST['crop_avatar_name'];
        $config['new_image'] = $this->config->item('user_avatar') . $large_image_name;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $_POST['avatar_w'];
        $config['height'] = $_POST['avatar_h'];
        $config['x_axis'] = $_POST['avatar_x'];
        $config['y_axis'] = $_POST['avatar_y'];
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);

        if ( ! $this->image_lib->crop()){
            $info['error'] = $this->image_lib->display_errors('', '');
        }else{
            //remove all old avatars from disk
            $avatar_name = $this->find_user_avatar();
            if($avatar_name != 'default_avatar.jpg'){
                $this->unlink_avatars($avatar_name);
            }
            //update the avatar name in users table
            if(!$this->update_avatar_name($ori_name)){
                $info['error'] = '插入用户数据表错误';
            }else{
                //resize the large avatar to 200*200
                $this->resize_large_avatar($large_image_name);
                //generate medium and small size which have same scale as large one
                $this->create_medium_avatar($ori_name);
                $this->create_small_avatar($ori_name);
                //delete the original one
                $file_path = $this->config->item('user_avatar') . $ori_name;
                if(file_exists($file_path)){
                    unlink($file_path);
                }

                $info['file_name'] = $large_image_name;
              }
        }
        return $info;
    }
    
    public function check_update_password(){
        //check and update the password
        $result = $this->db->select('Password')->get_where('users', array('UserID'=>$this->cur_user_id), 1);
        $row = $result->row();

        if($result->num_rows() === 1) {
            $old_password = trim($this->input->post('old_password'));
            $new_password = trim($this->input->post('new_password'));
            if($row->Password === sha1($this->config->item('pre_pwd').$old_password)) {
                // authenticated, now update the user's password
                $update_result = $this->update_password($this->cur_user_id, $new_password);
                return $update_result;
            }else {
                return 'incorrect_password';
            }
        }else {
            return FALSE;
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
    
    public function resend_vali_email(){
        $email = $this->input->post('email');
        $result = $this->db->select('Status, CreatedOn')->get_where('users', array('Email'=>$email));
        if($result->num_rows() === 1){
            $row = $result->row();
            switch ($row->Status){
                case 'N':
                    $email_code = md5((string)$row->CreatedOn);
                    $this->send_validation_email($email, $email_code);
                    return 'sent';
                    break;
                case 'A':
                    return 'activated';
                    break;
                default :
                    return 'not_avaiable';
                    break;
            }    
        }else{
            return FALSE;
        }
        
    }
    
    private function send_validation_email($email, $email_code){
        $this->load->library('email');
       
        $this->email->from('account@bridgeous.com', '比橙网');
        $this->email->to($email);
        $this->email->subject('请激活您比橙网的账号');
        //$this->email->reply_to('noreply@noreply.com');
        
        $message = '<!DOCTYPE html><head>
                    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
                    </head><body>';
        $message .= '<p>亲爱的比橙用户：</p>';
        // the link we send will look like /american_stock_world/register/validate_email/email_adress/md5_code
        $message .= '<p>感谢您注册比橙网！请点击以下链接来激活您的账户<p/>';
        $message .= '<p>' . base_url() .'register/validate_email/'  . $email .'/'. $email_code . '</p>';
        $message .= '<p>如不能点击请复制上面的链接到您的地址栏，谢谢！<p/>';
        $message .= '</body></html>';
        
        $this->email->message($message);
        if(!$this->email->send())
        {
            show_error($this->email->print_debugger());
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
    
    private function insert_user_history($user_id, $updated_by, $history){
        
        $updated_on = date('Y-m-d H:i:s', time());
        $insert_arr = array('UserId'=>$user_id, 'UpdatedBy'=>$updated_by, 'History'=>$history, 'UpdatedOn'=>$updated_on);
        $this->db->insert('user_history', $insert_arr);
        
        if($this->db->affected_rows() === 1){
            // inserted succesful           
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    private function update_password($user_id, $new_password){
        $new_password = sha1($this->config->item('pre_pwd').$new_password);
        $sql = "UPDATE users SET Password = '{$new_password}' WHERE UserId = '{$user_id}' LIMIT 1";
        $update_success = $this->db->query($sql);
        
        if($update_success) {
            return 'update_success';
        }else {
            //won't happen
            return FALSE;
        }
    }
    
    private function resize_to_crop_avatar($original_avatar){
        $config['source_image'] = $this->config->item('user_avatar') . $original_avatar;
        $config['new_image'] = $this->config->item('user_avatar') . insert_before_extension($original_avatar, '_crop');
        $config['width'] = $this->config->item('crop_avatar');
        $config['height'] = $this->config->item('crop_avatar');
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            $info['error'] = $this->image_lib->display_errors('', '');
        }else{
            $info['file_name'] = insert_before_extension($original_avatar, '_crop');
        }
        
        return $info;
    }
    
    private function unlink_avatars($avatar_name){
        if (strpos($avatar_name,'de') === false) { //check if it's default image
            $file_path = $this->config->item('user_avatar');
            //$image_array['original'] = $file_path . $avatar_name;
            $image_array['large'] = $file_path . insert_before_extension($avatar_name, '_large');
            $image_array['medium'] = $file_path . insert_before_extension($avatar_name, '_medium');
            $image_array['small'] = $file_path . insert_before_extension($avatar_name, '_small');
            //$image_array['crop'] = $file_path . insert_before_extension($avatar_name, '_crop');
            //check the image exists before remove it
            foreach ($image_array as $k => $v) {
                if(file_exists($v)){
                    unlink($v);
                }
            } //end of foreach
        }
    }
    
    private function update_avatar_name($image_name){
        $data['Avatar'] = $image_name;
        $this->db->where('UserID', $this->cur_user_id)->update('user_meta', $data);
        if($this->db->affected_rows() >= 0) {
            $this->session->set_userdata('avatar', $image_name);
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    private function resize_large_avatar($avatar_name){
        $config['source_image'] = $this->config->item('user_avatar') . $avatar_name;
        //$config['maintain_ratio'] = FALSE;
        $config['width'] = $config['height'] = $this->config->item('large_avatar_height');
        return generate_image($config);
    }
    
    private function create_medium_avatar($avatar_name){
        $config['source_image'] = $this->config->item('user_avatar') . insert_before_extension($avatar_name, '_large');
        $config['new_image'] = $this->config->item('user_avatar') . insert_before_extension($avatar_name, '_medium');
        $config['width'] = $config['height'] = $this->config->item('medium_avatar_height');
        return generate_image($config);
    }
    
    private function create_small_avatar($avatar_name){
        $config['source_image'] = $this->config->item('user_avatar') . insert_before_extension($avatar_name, '_large');
        $config['new_image'] = $this->config->item('user_avatar') . insert_before_extension($avatar_name, '_small');
        $config['width'] = $config['height'] = $this->config->item('small_avatar_height');
        return generate_image($config);
    }
    
    //-------------------------------------*** Below are functions for positions ***--------------------------
    public function find_all_published_positions($per_page, $start_row) {
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('positions', array('Status' => 'A', 'AuthorID' => $this->cur_user_id), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_all_deleted_positions($per_page, $start_row) {
        $result = $this->db->order_by("CreatedOn", "desc")->get_where('positions', array('Status' => 'D', 'AuthorID' => $this->cur_user_id), $per_page, $start_row);

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }

    public function find_position_by_id($position_id) {
        $result = $this->db->get_where('positions', array('PositionID' => $position_id), 1);

        if ($result->num_rows() === 1) {
            return $result->row();
        } else {
            return FALSE;
        }
    }
    
    public function create_position() {

        $data['Title'] = $this->input->post('title');
        $data['Field'] = $this->input->post('field');
        $data['Country'] = $this->input->post('country');
        $data['JobType'] = $this->input->post('job_type');
        $data['AuthorID'] = $this->session->userdata('user_id');
        //$data['ExpiredOn'] = $this->input->post('expired_on');
        $data['Description'] = $this->input->post('description');
        $data['CreatedOn'] = date('Y-m-d H:i:s', time());
        $data['CreatedFrom'] = $_SERVER['REMOTE_ADDR'];
        $data['Status'] = 'A';
        $data['Level'] = $this->config->item('default_post_level');

        $this->db->insert('positions', $data);

        if ($this->db->affected_rows() === 1) {
            return 'success';
        } else {
            return FALSE;
        }
    }
    
    public function update_position() {

        $position_id = $this->input->post('position_id');
        $data['Title'] = $this->input->post('title');
        $data['Field'] = $this->input->post('field');
        $data['Country'] = $this->input->post('country');
        $data['JobType'] = $this->input->post('job_type');
        $data['Description'] = $this->input->post('description');
        //$data['ExpiredOn'] = $this->input->post('expired_on');
        $data['UpdatedOn'] = date('Y-m-d H:i:s', time());

        $this->db->where('PositionID', $position_id)->update('positions', $data);
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
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
    
    /*
     * 3.30
     */
    public function find_user_all_info_by_id() {
        $this->db->join('users', "users.UserID = user_meta.UserID");
        $result = $this->db->get_where('user_meta', array('user_meta.UserID' => $this->cur_user_id));

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return FALSE;
        }
    }
    
    public function insert_verify_application($application) {
        $user_info = $this->find_user_all_info_by_id();
        if ($user_info[0]['Status'] === 'N')
            return 'not_activate';
        foreach ($user_info[0] as $info) {
            if (empty($info))
                return 'user_info_incomplete';
        }
        $data['VerifyUserID'] = $this->cur_user_id;
        $data['VerifyStatus'] = 'N';
        $data['Note'] = $application;
        $data['VerifyCreatedOn'] = date('Y-m-d H:i:s', time());

        $this->db->insert('verify', $data);

        if ($this->db->affected_rows() === 1) {
            // inserted succesful
            return 'sent';
        }
    }
    
    public function update_verify_application($application) {
        $data['note'] = $application;
        $this->db->where('VerifyUserID', $this->cur_user_id)->update('verify', $data);
        if ($this->db->affected_rows() === 1) {
            return 'success';
        } else {
            return 'fail';
        }
    }


    public function find_verify_info() {
        $result = $this->db->get_where('verify', array('VerifyUserID' => $this->cur_user_id));
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return FALSE;
        }
    }
//    public function resend_apply_email($application) {
//        $user_info = $this->find_user_all_info_by_id();
//        if ($user_info[0]['Status'] === 'N')
//            return 'not_activate';
//        foreach ($user_info[0] as $info) {
//            if ($info == NULL)
//                return 'user_info_incomplete';
//        }
//        $user_info[0]['Application'] = $application;
//        $email_code = md5((string) $user_info[0]['CreatedOn']);
//        $this->send_application_email($user_info[0], $email_code);
//        return 'sent';
//    }
//
//    private function send_application_email($user_info) {
//        $this->load->library('email');
//
//        $this->email->from('account@bridgeous.com');
//        $this->email->to('account_verification@bridgeous.com');
//        $this->email->subject('申请成为官方账号');
//        //$this->email->reply_to('noreply@noreply.com');
//
//        $message = <<<CONTENT
//                <!DOCTYPE html><head>
//                    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
//                    </head><body>'
//                <p>亲爱的比橙管理员：</p>
//                我的信息如下:
//                    用户的邮箱:{$user_info['Email']}
//                        账号建立时间:{$user_info['CreatedOn']}
//                            角色:{$user_info['Role']}
//                                姓名:{$user_info['Name']}
//                                    昵称:{$user_info['Nickname']}
//                                        电话:{$user_info['Phone']}
//                                            网站:{$user_info['Website']}
//                                                国家:{$user_info['Country']}
//                                                    用户的留言:{$user_info['Application']}
//                                                    </body></html>
//CONTENT;
//
//        $this->email->message($message);
//        if (!$this->email->send()) {
//            show_error($this->email->print_debugger());
//        }
//    }
    
    
}
