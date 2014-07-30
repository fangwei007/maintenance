<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function generate_image($config=''){
    $ci =& get_instance();
    $ci->load->library('image_lib');
    $ci->image_lib->initialize($config);
    if (!$ci->image_lib->resize()) {
        return $ci->image_lib->display_errors();
    }
}

    
    
