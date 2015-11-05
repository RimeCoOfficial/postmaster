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
