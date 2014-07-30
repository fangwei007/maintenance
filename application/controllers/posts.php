<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller {
    private $data;
    public function __construct() {
        parent::__construct();
        $this->load->model('model_posts');  
    }
    
    public function show_post($post_id=''){
        /*
         * Author: Wei Fang
         * Date: Mar.26th
         * Function: 收藏量
         */
        $this->data['collection'] = $this->model_posts->get_collection_count($post_id)->Collection;
        /*
         * Author: Wei
         * Date: Mar. 15th
         * Function: 访问量
         */
        //record the page count
        $ip = $_SERVER['REMOTE_ADDR'];
        $views_count_info = $this->model_posts->get_views_count_info($ip, $post_id);
        if(!$views_count_info) {
            $this->data['views_count_error'] = 'views count database operation failed';
        }
        //output the number of the post viewed
        $post_views_count = $this->model_posts->find_views_count_by_id($post_id);
        $this->data['views_count'] = $post_views_count[0]['ViewsNum'];
        
        $this->data['post'] = $this->model_posts->find_post_by_id($post_id);
        $this->data['category'] = $this->data['post']->Category;
        $this->get_sidebar_info($post_id);
        if($this->data['post']){
            switch ($this->data['post']->Type) {
                case 'article':
                    output_views('posts/view_article', $this->data, 'post');
                    break;
                case 'video':
                    output_views('posts/view_video', $this->data, 'post');
                    break;
                case 'event':
                    output_views('posts/view_event', $this->data, 'post');
                    break;
                default:
                    break;
            } 
        }else{
            output_views('posts/view_error_no_result');
        }
    }
    
    public function show_posts($category, $type, $offset=0){
        $this->get_sidebar_info();
        $config['uri_segment'] = 5;
        $config['base_url'] = base_url() . 'posts/show_posts/' . $category . '/' . $type . '/';
        $config['total_rows'] = $this->db->get_where('posts', array('Category' => $category, 'Type' => $type, 'Status' => 'A', 'Level >='=>2))->num_rows();
        $config['per_page'] = 10;
        $this->data['pagination'] = output_pagination($config);
        $this->data['category'] = $category;
        $this->data['type'] = $type;
        $this->data['posts'] = $this->model_posts->find_post_author_by_type_category($category, $type, $config['per_page'], $offset);
        switch ($type) {
            case 'article':
                output_views('posts/view_articles', $this->data, 'posts');
                break;
            case 'video':
                output_views('posts/view_videos', $this->data, 'posts');
                break;
            case 'event':
                output_views('posts/view_events', $this->data, 'posts');
                break;
            default:
                break;
        } 
    }
    
    private function get_sidebar_info($post_id=''){
        $this->load->library('get_data');
        if(!empty($post_id)){
            $this->data['author_info'] = $this->get_data->find_userdata_by_post_id($post_id);
        }
        $this->data['sidebar_articles'] = $this->get_data->find_latest_articles(5);
        $this->data['sidebar_events'] = $this->get_data->find_latest_events(5);
        $this->data['sidebar_positions'] = $this->get_data->find_latest_positions(5);
    }
    
    
    
}