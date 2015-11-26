<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_message_history
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_message_history');
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

  function add($owner, $message_id, $to_name, $to_email, $subject_vars, $message_vars)
  {
    if (!$this->CI->model_message_history->can_add($message_id, $owner))
    {
      $this->error = ['status' => 401, 'message' => 'invalid message_id'];
      return NULL;
    }

    if (empty($to_name)) $to_name = NULL;
    if (empty($subject_vars)) $subject_vars = NULL;
    if (empty($message_vars)) $message_vars = NULL;

    return $this->CI->model_message_history->add($message_id, $to_name, $to_email, $subject_vars, $message_vars);
  }
}