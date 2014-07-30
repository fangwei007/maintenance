<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('truncate_string'))
{
    function truncate_string($string, $max_length){
        if (mb_strlen($string) > $max_length){
            $string = mb_substr($string, 0, $max_length) . '...';
        }
        return $string;
    }
}

if ( ! function_exists('strip_single_tag'))
{
    function strip_single_tag($tag, $string){
        $string = preg_replace('/<'.$tag.'[^>]*>/i', '', $string);
        $string = preg_replace('/<\/'.$tag.'>/i', '', $string);
        return $string;
    }
}

if ( ! function_exists('strip_http_links'))
{
    function strip_http_links($string){
        $pattern = '~http://[^\s]*~i';
        $string = preg_replace($pattern, '', $string);
        return $string;
    }
}

if ( ! function_exists('insert_before_extension'))
{   // this function is used to insert a string before the extension of a file(ex. change the image.jpg to image_thumb.jpg)
    function insert_before_extension($file_name='', $insert_string='')
    {
        $extension_pos = strrpos($file_name, '.'); // find position of the last dot, so where the extension starts
        $new_name = substr($file_name, 0, $extension_pos) . $insert_string . substr($file_name, $extension_pos);
        return $new_name;
    }   
}