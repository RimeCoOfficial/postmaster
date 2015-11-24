<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_api
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
  }
  
  /**
   * Get error message.
   * Can be invoked after any failed operation.
   *
   * @return  string
   */
  function get_error_message()
  {
    return $this->error;
  }
  
  function check_api_key()
  {
    $api_key = $this->CI->input->post('key');
    if ($api_key != getenv('api_key'))
    {
      $this->error = ['status' => 401, 'message' => 'invalid key'];
      return NULL;
    }

    return TRUE;
  }
}