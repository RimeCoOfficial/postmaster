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

  function create($transaction_id, $label_id)
  {
    $this->CI->model_transaction->create($transaction_id, $label_id);
    return TRUE;
  }

  function modify($transaction_id, $label_id)
  {
    $this->CI->model_transaction->update($transaction_id, $label_id);
    return TRUE;
  }
}