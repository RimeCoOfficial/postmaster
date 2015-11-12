<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function valid_email($str)
{
  $CI =& get_instance();

  // 1. lowercse
  $str = strtolower($str);

  // 2. idn to ascii
  $CI->load->library('composer/lib_idna_convert');
  $str = $CI->lib_idna_convert->encode($str);

  // 3. trim
  $str = trim($str);

  // 4. required
  if (empty($str)) return NULL;

  // 5. max length
  $CI->config->load('form_element', TRUE);

  $email_element = $CI->config->item('email', 'form_element');
  $email_max_length = $email_element['max_length'];
  if (strlen($str) > $email_max_length) return NULL;

  return filter_var($str, FILTER_VALIDATE_EMAIL) ? $str : NULL;
}

function report_error($subject, $template, $data)
{
  if (!is_null($CI =& get_instance())
    // AND ENVIRONMENT === 'production'
  )
  {
    $data['debug_backtrace'] = NULL;
    $data['backtrace'] = array();
    if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE)
    {
      // $data['debug_backtrace'] = debug_backtrace();
      foreach (debug_backtrace() as $error)
      {
        if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0)
        {
          $b['file'] = $error['file'];
          $b['line'] = $error['line'];
          $b['function'] = $error['function'];

          $b['args'] = $error['args'];

          $data['backtrace'][] = $b;
        }
      }
    }

    if (is_cli()) $subject = 'CLI: '.$subject;

    $data['ip']       = is_cli() ? NULL : $CI->input->ip_address();

    $data['request']  = $_REQUEST;
    $data['server']   = is_cli() ? NULL : $CI->input->server(NULL);
    
    $CI->load->library('lib_send_email');
    $CI->lib_send_email->general(getenv('email_debug'), $subject, $template, $data);
  }
}