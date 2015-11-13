<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_message
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_message');
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
    return $this->CI->model_message->get($message_id);
  }

  function get_list()
  {
    return $this->CI->model_message->get_list();
  }

  function create($subject)
  {
    return $this->CI->model_message->create($subject);
  }

  function modify($message_id, $subject, $reply_to_name, $reply_to_email, $message_html)
  {
    if (empty($reply_to_name)) $reply_to_name = NULL;
    if (empty($reply_to_email)) $reply_to_email = NULL;

    $this->CI->model_message->update($message_id, $subject, $reply_to_name, $reply_to_email, $message_html);
    return TRUE;
  }
}