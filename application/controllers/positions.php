<?php

class Positions extends CI_Controller {
    private $data;
    public function __construct() {
        parent::__construct();
        $this->load->model('model_positions');
    }

    public function show_position($position_id) {
        /*
         * Author: Wei Fang
         * Date: Mar.26th
         * Function: 收藏量
         */
        $this->data['collection'] = $this->model_positions->get_collection_count($position_id)->Collection;
        /*
         * Author: Wei
         * Date: Mar. 15th
         * Function: 访问量
         */
        $ip = $_SERVER['REMOTE_ADDR'];
        $views_count_info = $this->model_positions->get_views_count_info($ip, $position_id);
        if($views_count_info) {
            $this->data['views_count_info'] = 'views count database operation success!!';
        }

        $position_views_count = $this->model_positions->find_views_count_by_id($position_id);
        $this->data['views_count'] = $position_views_count[0]['ViewsNum'];
        
        $this->data['category'] = 'career'; //set the category for the menu active
        $this->data['position'] = $this->model_positions->find_position_by_id($position_id);
        $this->get_sidebar_info($position_id);
        if ($this->data['position']) {
            output_views('positions/view_position', $this->data, 'position');
        } else {
            output_views('positions/view_error_no_result');
        }
    }
    
    public function show_positions($offset = 0) {
        $this->data['category'] = 'career'; //set the category for the menu active
        $this->get_sidebar_info();

        $config['base_url'] = base_url() . 'positions/show_positions';
        if (isset($_GET['position_search'])) {
//            var_dump($_GET['position_search']);
            if (count($_GET) > 0)
                $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
            if ($this->model_positions->retrieve_positions($_GET['position_search']) != false) {
                $config['total_rows'] = $this->model_positions->retrieve_positions($_GET['position_search'])->num_rows();
            } else {
                $config['total_rows'] = $this->db->get_where('positions', array('Status' => 'A'))->num_rows();
            }
            $config['per_page'] = $this->config->item('positions_per_page');
            $this->data['pagination'] = output_pagination($config);
            $this->data['positions'] = $this->model_positions->find_position_by_keywords($config['per_page'], $offset, $_GET['position_search']);
            
        } else {
            /** 下面精彩了，完美解决url和GET search问题* */
            if (count($_GET) > 0)
                $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
            /* --------------------------------------- */

            if ($this->model_positions->find_all_positions_by_filters($_GET) != false) {
                $config['total_rows'] = $this->model_positions->find_all_positions_by_filters($_GET)->num_rows();
            } else {
                $config['total_rows'] = $this->db->get_where('positions', array('Status' => 'A'))->num_rows();
            }
            $config['per_page'] = $this->config->item('positions_per_page');
    //        $config['use_page_numbers'] = TRUE;
    //        $config['page_query_string'] = true;
            $this->data['pagination'] = output_pagination($config);
            if ($_GET) {
                $this->data['positions'] = $this->model_positions->find_position_by_filters($config['per_page'], $offset, $_GET);
            } else {
                $this->data['positions'] = $this->model_positions->find_position_author($config['per_page'], $offset);
            }
        }
            $this->category = 'career'; //set the category for the menu active
            output_views('positions/view_positions', $this->data, 'positions');
        
    }
    
    private function get_sidebar_info($position_id=''){
        $this->load->library('get_data');
        if(!empty($position_id)){
            $this->data['author_info'] = $this->get_data->find_userdata_by_position_id($position_id);
        }
        $this->data['sidebar_articles'] = $this->get_data->find_latest_articles(5);
        $this->data['sidebar_events'] = $this->get_data->find_latest_events(5);
        $this->data['sidebar_positions'] = $this->get_data->find_latest_positions(5);
    }
   
    

}
