<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends CI_Controller {
    private $data;
    function __construct() {
        parent::__construct();
        $this->load->model('model_comments');
        $this->load->library('form_validation');
    }

    public function add_comment($post_id, $type){
        //rules of validation
        $this->form_validation->set_rules('comment', 'lang:comment', 'trim|strip_tags|required|max_length[200]|xss_clean');

        if($this->form_validation->run() === FALSE){
            //didn't validate, send back to comment form and show errors
            $vali_error['st'] = 0;
            $vali_error['error'] = strip_tags(form_error('comment'));

            echo json_encode($vali_error);
        }else{
            $result = $this->model_comments->insert_comment($post_id, $type); //return comment type(post or position)
            if($result === 'blocked_user'){
                echo json_encode(array('st'=>0, 'error' => lang('blocked_user')));
            }elseif($result === 'frequent_comment'){
                echo json_encode(array('st'=>0, 'error' => lang('frequent_comment')));
            }elseif($result){
                echo json_encode(array('st'=>1, 'type' => $result, 'postID' => $post_id));
            }else {
                echo json_encode(array('st'=>0, 'error' => lang('comment_failed')));
            }
        }
    }
    
    public function show_comments($post_id, $post_type){
        $limit = $this->config->item("comments_per_page");
        $this->data['comments'] = $this->model_comments->find_comments_by_post_id($post_id, $post_type, $limit);
        $this->load->view('comments/view_comments', $this->data);
    }
    
    public function load_more_comments($post_id, $post_type, $offset){
        $limit = $this->config->item("comments_per_page");
        $this->data['comments'] = $this->model_comments->find_comments_by_post_id($post_id, $post_type, $limit, $offset);
        if($this->data['comments']){
            $this->load->view('comments/view_comments', $this->data);
        }
    }
    
    
//    public function show_position_comments($position_id){
//        $limit = $this->config->item("comments_per_page");
//        $this->data['comments'] = $this->model_comments->find_comments_by_position_id($position_id, $limit);
//        $this->load->view('comments/view_comments', $this->data);
//    }
//    
//    public function load_more_position_comments($position_id, $offset){
//        $limit = $this->config->item("comments_per_page");
//        $this->data['comments'] = $this->model_comments->find_comments_by_position_id($position_id, $limit, $offset);
//        if($this->data['comments']){
//            $this->load->view('comments/view_comments', $this->data);
//        }
//    }
    
    public function delete_comment(){
        if($_POST['comment_id']){
            $result = $this->model_comments->delete_comment($_POST['comment_id']);
            if($result){
                echo json_encode(array('st'=>1));
            }
        }
    }
    
    
}
