<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Exceptions Class
*
* Extends CI Exceptions
*
* @author     http://stackoverflow.com/questions/260597/in-codeigniter-how-can-i-have-php-error-messages-emailed-to-me
*/
class MY_Exceptions extends CI_Exceptions
{
  function __construct()
  {
    return parent::__construct();
  }
  
  function show_error($heading, $message, $template = 'error_general', $status_code = 500)
  {
    // if (!is_cli() AND $status_code == 500)
    if ($status_code >= 500)
    {
      if (!is_null($CI =& get_instance()))
      {
        $data['heading'] = $heading;
        $data['message'] = is_array($message) ? '<pre>'.print_r($message, TRUE).'</pre>' : $message;
        $data['status_code'] = $status_code;

        $CI->load->helper('email');
        report_error('HTTP Error 500: Internal server error', 'error/error_general', $data);
      }
    }

    return parent::show_error($heading, $message, $template, $status_code = 500);
  }

  function log_exception($severity, $message, $filepath, $line)
  {
    if (!is_null($CI =& get_instance()))
    {
      $data['severity'] = $severity;
      $data['message']  = $message;
      $data['filepath'] = $filepath;
      $data['line']     = $line;

      $CI->load->helper('email');
      report_error('A PHP Error was encountered', 'error/error_php', $data);
    }
    
    return parent::log_exception($severity, $message, $filepath, $line);
  }
}