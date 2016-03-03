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
    if (!is_null($CI =& get_instance()) AND $status_code >= 500)
    {
      $error_data['heading'] = $heading;
      $error_data['message'] = is_array($message) ? '<pre>'.print_r($message, TRUE).'</pre>' : $message;

      $CI->load->helper('email');
      report_error($template, $error_data);
    }

    return parent::show_error($heading, $message, $template, $status_code);
  }

  function show_php_error($severity, $message, $filepath, $line)
  {
    if (!is_null($CI =& get_instance()))
    {
      $error_data['severity'] = $severity;
      $error_data['message'] = $message;
      $error_data['filepath'] = $filepath;
      $error_data['line'] = $line;

      $CI->load->helper('email');
      report_error('error_php', $error_data);
    }

    return parent::show_php_error($severity, $message, $filepath, $line);
  }

  function show_exception($exception)
  {
    if (!is_null($CI =& get_instance()))
    {
      $message = $exception->getMessage();
      if (empty($message))
      {
        $message = '(null)';
      }

      $error_data['exception'] = $exception;
      $error_data['message'] = $message;

      $CI->load->helper('email');
      report_error('error_exception', $error_data);
    }
    
    return parent::show_exception($exception);
  }
}