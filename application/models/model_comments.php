<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_comments extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    public function insert_comment($post_id, $type){
        $validation = $this->check_insert_available(); //check if current user can post comments
        if($validation === 'blocked_user'){
            return 'blocked_user';
        }elseif($validation === 'frequent_comment'){
            return 'frequent_comment';
        }else{
            //user is available to post comment
            $insert_arr['PostID'] = $post_id;
            $insert_arr['Body'] = $this->input->post('comment');
            $insert_arr['InsertUserID'] = get_user_session('user_id');
            $insert_arr['InsertDate'] = date('Y-m-d H:i:s', time());
            $insert_arr['InsertIP']= $_SERVER['REMOTE_ADDR'];
            $insert_arr['PostType']= $type;
            $insert_arr['ReplyToComment'] = $this->input->post('reply_to_comment') ? $this->input->post('reply_to_comment') : '';
            $insert_arr['ReplyToUser'] = $this->input->post('reply_to_user') ? $this->input->post('reply_to_user') : '';
    //        $insert_arr['PostAuthorID'] = $this->get_author_by_post_id($post_id, $type);
            $this->db->insert('comments', $insert_arr);

            if($this->db->affected_rows() === 1){
                // inserted succesful
                return $type;
            }else{
                return false;
            }
        }
    }
    
    private function check_insert_available(){
        $status = $this->db->get_where('users', array('UserID'=>get_user_session('user_id')));
        //if user is blocked
        if($status->row()->Status === 'B'){
            return 'blocked_user';
        }else{
            //get the time of user's latest comment
            $result = $this->db->order_by('InsertDate')->get_where('comments', array('InsertUserID'=>get_user_session('user_id')), 1);
            if($result->num_rows() === 1){
                //user can only 1 post comment in 60 sec
                if(time() - strtotime($result->row()->InsertDate) < 60){
                    return 'frequent_comment';
                }else{
                    return 'avaiable';
                }
            }else{
                return 'avaiable';
            }
        }
    }
//    private function get_author_by_post_id($post_id, $type){
//        if($type === 'post'){
//            $result = $this->db->get_where('posts', array('PostID'=>$post_id), 1);
//            if($result->num_rows() === 1){
//                return $result->row()->AuthorID;
//            }
//        }elseif($type === 'position'){
//            $result = $this->db->get_where('positions', array('PositionID'=>$post_id), 1);
//            if($result->num_rows() === 1){
//                return $result->row()->AuthorID;
//            }
//        }
//        
//    }
    
    public function find_comments_by_post_id($post_id, $post_type, $limit=10, $offset=0){
        $this->db->join('user_meta', 'user_meta.UserID = comments.InsertUserID');
        $result = $this->db->order_by('InsertDate','desc')->get_where('comments', array('PostID'=>$post_id, 'PostType'=>$post_type), $limit, $offset);
        if($result->num_rows() > 0){
            //add reply user's nick name to the array
            $comment_arr = $result->result_array();
            for($i = 0; $i < count($comment_arr); $i++){
                $u = $this->db->get_where('user_meta', array('UserID'=>$comment_arr[$i]['ReplyToUser']),1);
                if($u->num_rows() === 1){
                    $comment_arr[$i]['ReplyToName'] = $u->row()->Nickname;
                }
            }
            return $comment_arr;
        }else {
            return FALSE;
        } 
    }
    
    public function delete_comment($comment_id){
        $this->db->delete('comments', array('CommentID' => $comment_id));
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
}