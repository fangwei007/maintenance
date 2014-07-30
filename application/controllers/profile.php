<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
    private $data;
    public function __construct() {
        parent::__construct();
        $this->load->model('model_profile');
    }
    
//    function _remap($method,$args){
//        if (method_exists($this, $method)){
//            $this->$method($args);
//        }else {
//            $this->user_profile($method,$args);
//        }
//    }
    
    public function user_profile($nickname,$offset=0){
        //if users view their own profile, redirect them to their account page
        if(get_user_session('nickname') === urldecode($nickname)){
            redirect('/my_account','location');
        }
        $this->get_sidebar_info();
        //decode the UTF8 encode
        $nickname = !empty($nickname) ? urldecode($nickname) : '';
        //get the user's profile
        $this->data['user_profile'] = $this->model_profile->find_user_info_by_nickname($nickname);
        if(!empty($this->data['user_profile'])){
            //set the pagination
            $config['uri_segment'] = 4;
            $config['base_url'] = base_url() . 'profile/user_profile/' . $nickname . '/';
            $config['total_rows'] = $this->db->get_where('posts', array('AuthorID' => $this->data['user_profile']->UserID))->num_rows();
            $config['per_page'] = 10;
            $this->data['pagination'] = output_pagination($config);
            //get the user's posts
            $this->data['posts'] = $this->model_profile->find_posts_by_author_id($this->data['user_profile']->UserID, $config['per_page'], $offset);
            output_views('profile/view_user_profile', $this->data);
        }else{
            output_views('profile/view_user_profile_error');
        }
    }
    
    public function user_post_positions($nickname,$offset=0) {
        $this->get_sidebar_info();
        //decode the UTF8 encode
        $nickname = !empty($nickname) ? urldecode($nickname) : '';
        //get the user's profile
        $this->data['user_profile'] = $this->model_profile->find_user_info_by_nickname($nickname);
        if(!empty($this->data['user_profile'])){
            //set the pagination
            $config['uri_segment'] = 4;
            $config['base_url'] = base_url() . 'profile/user_post_positions/' . $nickname . '/';
            $config['total_rows'] = $this->db->get_where('positions', array('AuthorID' => $this->data['user_profile']->UserID))->num_rows();
            $config['per_page'] = 10;
            $this->data['pagination'] = output_pagination($config);
            //get the user's posts
            $this->data['positions'] = $this->model_profile->find_positions_by_author_id($this->data['user_profile']->UserID, $config['per_page'], $offset);
            output_views('profile/view_user_post_positions', $this->data);
        }else{
            output_views('profile/view_user_post_positions');
        }
    }
    
    public function verified_users($role_type, $offset=0) {
        $this->get_sidebar_info();
        $config['uri_segment'] = 4;
        $config['base_url'] = base_url() . 'profile/verified_users/' . $role_type . '/';
        $config['total_rows'] = $this->db->get_where('users', array('Role' => $role_type, 'Status' => 'V'))->num_rows();
        $config['per_page'] = 10;
        $this->data['pagination'] = output_pagination($config);
        $this->data['users'] = $this->model_profile->find_verified_users_by_role_type($role_type, $config['per_page'], $offset);
        $this->data['role_type'] = $role_type;
        output_views('profile/view_verified_users', $this->data);
        
        
    }
    
    public function follow(){
        //used to follow other via AJAX
        if(isset($_POST['user_id'])){
            if((int)$_POST['status'] === 1){     //gonna unfollow this user
                $result = $this->model_profile->unfollow_user($_POST['user_id']);
                if($result){
                    echo json_encode(array('st'=>1, 'fn'=>'unfollow', 'userID'=>$_POST['user_id'], 'text'=>lang('follow')));
                }else {
                    //failed
                    echo json_encode(array('st'=>0));
                }
            }else{
                $result = $this->model_profile->follow_user($_POST['user_id']);
                if($result){
                    echo json_encode(array('st'=>1,'fn'=>'follow','userID'=>$_POST['user_id'],'text'=>lang('unfollow')));
                }else {
                    //failed
                    echo json_encode(array('st'=>0));
                }
            }     
        }
    }
    
    /*
     * Author: Wei Fang
     * Date: Mar. 9th
     * Function: add colletion
     */
    public function watch_list(){
        //used to follow other via AJAX
        if(isset($_POST['post_id'])){
            if((int)$_POST['status'] === 1){     //gonna unfollow this user
                $result = $this->model_profile->del_watch_list($_POST['post_id'], $_POST['post_type']);
                if($result){
                    echo json_encode(array('st'=>1, 'fn'=>'unstow', 'postID'=>$_POST['post_id'],'postType'=>$_POST['post_type'], 'text'=>lang('stow')));
                }else {
                    //failed
                    echo json_encode(array('st'=>0));
                }
            }else{
                $result = $this->model_profile->add_watch_list($_POST['post_id'], $_POST['post_type']);
                if($result){
                    echo json_encode(array('st'=>1,'fn'=>'stow','postID'=>$_POST['post_id'],'postType'=>$_POST['post_type'],'text'=>lang('unstow')));
                }else {
                    //failed
                    echo json_encode(array('st'=>0));
                }
            }     
        }
    }
    
    private function get_sidebar_info(){
        $this->load->helper('text');
        $this->load->library('get_data');
        $this->data['sidebar_articles'] = $this->get_data->find_latest_articles(5);
        $this->data['sidebar_events'] = $this->get_data->find_latest_events(5);
        $this->data['sidebar_positions'] = $this->get_data->find_latest_positions(5);
    }
    
}