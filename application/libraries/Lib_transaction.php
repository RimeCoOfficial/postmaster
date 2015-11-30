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

  function modify($message_id, $label_id)
  {
    if (empty($label_id)) $label_id = NULL;

    $this->CI->model_transaction->update($message_id, $label_id);
    return TRUE;
  }

  function add_message()
  {
    $this->CI->load->library('lib_message_history');

    $message_id = $this->CI->input->post('message_id');

    $to_name = $this->CI->input->post('to_name');

    if (is_null($to_email = valid_email($this->CI->input->post('to_email'))))
    {
      $this->error = ['status' => 401, 'message' => 'invalid email address in to_email'];
      return NULL;
    }

    $subject_var = $this->CI->input->post('subject');
    $body_var = $this->CI->input->post('body');
    
    if (is_null($history_id = $this->CI->lib_message_history->add(
      'transaction', $message_id, $to_name, $to_email, $subject_var, $body_var)))
    {
      $this->error = $this->CI->lib_message_history->get_error_message();
      return NULL;
    }

    return ['message_history_id' => $history_id];
  }
}