<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//this function is used to output views
function output_views($view_path='', $view_para='', $view_style=''){
    $ci =& get_instance();
    switch ($view_style) {
        case 'my_account':
            $ci->load->view('includes/header',$view_para);
            $ci->load->view('my_account/includes/view_my_account_header');
            $ci->load->view($view_path);
            $ci->load->view('my_account/includes/view_my_account_footer');
            $ci->load->view('includes/footer');
            break;
        case 'posts':
            $ci->load->view('includes/header',$view_para);
            $ci->load->view('posts/includes/view_posts_header');
            $ci->load->view($view_path);
            $ci->load->view('posts/includes/view_posts_footer');
            $ci->load->view('includes/footer');
            break;
        case 'post':
            $ci->load->view('includes/header',$view_para);
            $ci->load->view('posts/includes/view_post_header');
            $ci->load->view($view_path);
            $ci->load->view('posts/includes/view_post_footer');
            $ci->load->view('includes/footer');
            break;
        case 'positions':
            $ci->load->view('includes/header',$view_para);
            $ci->load->view('positions/includes/view_positions_header');
            $ci->load->view($view_path);
            $ci->load->view('positions/includes/view_positions_footer');
            $ci->load->view('includes/footer');
            break;
        case 'position':
            $ci->load->view('includes/header',$view_para);
            $ci->load->view('positions/includes/view_position_header');
            $ci->load->view($view_path);
            $ci->load->view('positions/includes/view_position_footer');
            $ci->load->view('includes/footer');
            break;
        case 'dashboard':
            $ci->load->view('includes/header',$view_para);
            $ci->load->view('admin/dashboard/view_dashboard_header');
            $ci->load->view($view_path);
            $ci->load->view('admin/dashboard/view_dashboard_footer');
            $ci->load->view('includes/footer');
            break;
        default:
            $ci->load->view('includes/header',$view_para);
            $ci->load->view($view_path);
            $ci->load->view('includes/footer');
            break;
    }
}   

//this function is used to output pagination
function output_pagination($config=''){
    $ci =& get_instance();
    $ci->load->library('pagination');
    $config['base_url'] = !empty($config['base_url']) ? $config['base_url'] : base_url();
    $config['total_rows'] = !empty($config['total_rows']) ? $config['total_rows'] : 100;
    $config['uri_segment'] = !empty($config['uri_segment']) ? $config['uri_segment'] : 3;
    $config['per_page'] = !empty($config['per_page']) ? $config['per_page'] : 10;
    $config['num_links'] = !empty($config['num_links']) ? $config['num_links'] : 6;
    
    //set the bootstrap css
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul><!--pagination-->';

    $config['first_link'] = '&laquo; 第一页';
    $config['first_tag_open'] = '<li class="prev page">';
    $config['first_tag_close'] = '</li>';

    $config['last_link'] = '最后一页 &raquo;';
    $config['last_tag_open'] = '<li class="next page">';
    $config['last_tag_close'] = '</li>';

    $config['next_link'] = '下一页 &rarr;';
    $config['next_tag_open'] = '<li class="next page">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = '&larr; 前一页';
    $config['prev_tag_open'] = '<li class="prev page">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="active"><a href="">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    
    $ci->pagination->initialize($config);
    return $ci->pagination->create_links();
}

function readable_time_format($date_time='',$format='', $timezone=''){
    $ci =& get_instance();
    if(empty($timezone)){
        date_default_timezone_set('America/New_York');
    }else{
        date_default_timezone_set($timezone);
    }
    $time = strtotime($date_time);
    switch ($format) {
        case 'ymd': //just show year, month, day
            return date("Y年n月j日", $time);
            break;
        case 'ym': //just show year, month, day
            return date("Y年n月", $time);
            break;
        case 'md': //just show month, day
            return date("n月j日", $time);
            break;
        case 'hi': //just show time
            return date("G点i分", $time);
            break;
        case 'mdhi': //just show time and date without year
            return date("n月j日 G点i分", $time);
            break;
        default:
            return date("Y年n月j日 G点i分", $time);
            break;
    }       
}


function active_page($category, $value){
    return $category === $value ? 'active' : '';
}

function cur_user_id(){
    $ci =& get_instance();
    return $ci->session->userdata('user_id') ? $ci->session->userdata('user_id') : FALSE;
}

function cur_user_role(){
    $ci =& get_instance();
    return $ci->session->userdata('role') ? $ci->session->userdata('role') : '';
}

function get_user_session($user_info){
    $ci =& get_instance();
    return $ci->session->userdata($user_info);
}