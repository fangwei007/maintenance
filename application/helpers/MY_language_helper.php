<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//overwrote the lang function
function lang($line, $vars = array())
{
    $CI =& get_instance();
    $line = $CI->lang->line($line);

    if ($vars)
    {
        $line = vsprintf($line, (array) $vars);
    }

    return $line;
}
?>
