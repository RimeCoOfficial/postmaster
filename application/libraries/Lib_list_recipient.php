<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_list_recipient
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();

    $this->CI->load->model('model_list_recipient');
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

  function get($list_id, $list_recipient_id, $to_name = '', $to_email = '')
  {
    $list_recipient = $this->CI->model_list_recipient->get($list_id, $list_recipient_id);

    if (empty($list_recipient))
    {
      $this->CI->model_list_recipient->create($list_id, $list_recipient_id, $to_name, $to_email);
      $list_recipient = $this->CI->model_list_recipient->get($list_id, $list_recipient_id);
    }
    
    return $list_recipient;
  }
}