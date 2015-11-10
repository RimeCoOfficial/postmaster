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

  function get($transaction_id)
  {
    return $this->CI->model_transaction->get($transaction_id);
  }

  function get_list()
  {
    return $this->CI->model_transaction->get_list();
  }

  function create($subject)
  {
    return $this->CI->model_transaction->create($subject);
  }

  function modify($transaction_id, $subject, $reply_to_name, $reply_to_email)
  {
    if (empty($reply_to_name)) $reply_to_name = NULL;
    if (empty($reply_to_email)) $reply_to_email = NULL;

    $this->CI->model_transaction->update($transaction_id, $subject, $reply_to_name, $reply_to_email);
    return TRUE;
  }

}