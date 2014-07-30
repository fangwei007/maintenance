<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    private $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('model_home');
        $this->load->library('pagination');
    }

    public function index() {
        $this->show_articles();
        $this->show_events();
        $this->show_career_news();
        $this->show_school_zones();
        $this->show_industry_zones();
        $this->show_person_zones();
        output_views('home/view_home', $this->data);
    }

    public function show_articles() {
        $blogs_list = $this->model_home->find_all_articles_videos(8);
        //get the author's name by author id
        if(!empty($blogs_list)){
            for($i=0; $i < count($blogs_list); $i++){
                $blogs_list[$i]['AuthorName'] = $this->model_home->find_author_name_by_id($blogs_list[$i]['AuthorID']) ;
            }
        }
        $this->data['blogs_list'] = $blogs_list;
    }

    //it used for the inifite scrolling
    public function load_more_articles($offset=""){
        $limit = 8;
        $blogs_list = $this->model_home->find_more_articles_videos($limit, $offset);
        //get the author's name by author id
        if(!empty($blogs_list)){
            for($i=0; $i < count($blogs_list); $i++){
                $blogs_list[$i]['AuthorName'] = $this->model_home->find_author_name_by_id($blogs_list[$i]['AuthorID']) ;
            }
        }
        $data['blogs_list'] = $blogs_list;
        if($data['blogs_list']){
            $this->load->view('home/view_articles', $data);
        }
    }
    
//    public function show_videos() {
//        $videos = $this->model_home->find_all_videos(4);
//        //set the image to default if it's null
//        if(!empty($videos)){
//            for($i=0; $i < count($videos); $i++){
//                $videos[$i]['Image'] = empty($videos[$i]['Image']) ? $this->config->item('default_video_image') : $videos[$i]['Image'];
//            }
//        }
//        $this->data['videos_list'] = $videos;
//    }

    public function show_events() {
        $this->data['events_list'] = $this->model_home->find_all_events(4);
    }

    public function show_school_zones() {
        $school = $this->model_home->find_all_zones_school(4);
        //set the avatar to default if it's null
        if(!empty($school)){
            for($i=0; $i < count($school); $i++){
                $school[$i]['Avatar'] = empty($school[$i]['Avatar']) ? $this->config->item('default_avatar') : $school[$i]['Avatar'];
            }
        }
        $this->data['school_zone_list'] = $school;
    }

    public function show_industry_zones() {
        $industry = $this->model_home->find_all_zones_industry(4);
        //set the avatar to default if it's null
        if(!empty($industry)){
            for($i=0; $i < count($industry); $i++){
                $industry[$i]['Avatar'] = empty($industry[$i]['Avatar']) ? $this->config->item('default_avatar') : $industry[$i]['Avatar'];
            }
        }
        $this->data['industry_zone_list'] = $industry;
    }

    public function show_person_zones() {
        $person = $this->model_home->find_all_zones_person(4);
        //set the avatar to default if it's null
        if(!empty($person)){
            for($i=0; $i < count($person); $i++){
                $person[$i]['Avatar'] = empty($person[$i]['Avatar']) ? $this->config->item('default_avatar') : $person[$i]['Avatar'];
            }
        }
        $this->data['person_zone_list'] = $person;
    }

    public function show_career_news() {
        $this->data['career_list'] = $this->model_home->find_all_positions(8);
    }
    

}