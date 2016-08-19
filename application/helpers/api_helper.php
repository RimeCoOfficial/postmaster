<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function output($response, $status_header = 200) // , $content_type = )
{
    $CI =& get_instance();
    $CI->output
        ->set_status_header($status_header)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();
        
    exit;
}

function output_error($error)
{
    $status_header = 500;
    if (!empty($error['status']))
    {
        $status_header = $error['status'];
        unset($error['status']);
    }

    output($error, $status_header);
}