<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_transaction
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_transaction');
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

  function get($message_id)
  {
    return $this->CI->model_transaction->get($message_id);
  }

  function get_list()
  {
    return $this->CI->model_transaction->get_list();
  }

  function get_available_message_list()
  {
    return $this->CI->model_transaction->get_available_message_list();
  }

  function create($message_id, $label_id)
  {
    if (empty($label_id)) $label_id = NULL;

    $this->CI->model_transaction->create($message_id, $label_id);
    return TRUE;
  }

  function modify($message_id, $label_id)
  {
    if (empty($label_id)) $label_id = NULL;

    $this->CI->model_transaction->update($message_id, $label_id);
    return TRUE;
  }

  function delete($message_id)
  {
    $this->CI->model_transaction->delete($message_id);
  }
}