<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('sort_array_by_time'))
{
    function sort_array_by_time($array){
        if(!empty($array)){
            usort($array, "cmp");
            return $array;
        }
    }
    function cmp($a, $b) //this function is working for the sort_array_by_time
    {
        $ac = $a->createdOn;
        $bc = $b->createdOn;
        if ($ac === $bc) {
            return 0;
        }
        return ($ac < $bc) ? 1 : -1; //order by ASC
    }
}