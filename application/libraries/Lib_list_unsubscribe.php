<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_list_unsubscribe
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();

    $this->CI->load->model('model_list_unsubscribe');
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

  function get($list_id)
  {
    return $this->CI->model_list_unsubscribe->get($list_id);
  }

  function get_list()
  {
    return $this->CI->model_list_unsubscribe->get_list();
  }

  function create($list, $type)
  {
    return $this->CI->model_list_unsubscribe->create($list, $type);
  }

  function update($list_id, $list)
  {
    $this->CI->model_list_unsubscribe->update($list_id, $list);
    return TRUE;
  }

  // function archive($list_id)
  // {
  //   return $this->CI->model_list_unsubscribe->archive($list_id);
  // }
}