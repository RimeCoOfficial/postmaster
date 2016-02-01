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

  function subscribe($list_id)
  {
    $list_recipient_id = $this->CI->input->post('list_recipient_id');
    if (empty($list_recipient_id))
    {
      $this->error = ['status' => 401, 'message' => 'missing parameter list_recipient_id'];
      return NULL;
    }

    $to_name = $this->CI->input->post('to_name');

    if (is_null($to_email = valid_email($this->CI->input->post('to_email'))))
    {
      $this->error = ['status' => 401, 'message' => 'invalid email address in to_email'];
      return NULL;
    }

    $subscribed = $this->CI->input->post('subscribed');
    $subscribed = strtotime($subscribed);

    if ($subscribed == FALSE)
    {
      $this->error = ['status' => 401, 'message' => 'subscribed: parameter missing or ill formated'];
      return NULL;
    }

    $subscribed = date('Y-m-d H:i:s', $subscribed);

    $list_recipient = $this->get($list_id, $list_recipient_id, $to_name, $to_email);
    $this->CI->model_list_recipient->subscribe($list_recipient['auto_recipient_id'], $subscribed);
    
    return ['200' => 'OK'];
  }

  function unsubscribe($list_id)
  {
    $list_recipient_id = $this->CI->input->post('list_recipient_id');
    if (empty($list_recipient_id))
    {
      $this->error = ['status' => 401, 'message' => 'missing parameter list_recipient_id'];
      return NULL;
    }

    $to_name = $this->CI->input->post('to_name');

    if (is_null($to_email = valid_email($this->CI->input->post('to_email'))))
    {
      $this->error = ['status' => 401, 'message' => 'invalid email address in to_email'];
      return NULL;
    }

    $unsubscribed = $this->CI->input->post('unsubscribed');
    $unsubscribed = strtotime($unsubscribed);

    if ($unsubscribed == FALSE)
    {
      $this->error = ['status' => 401, 'message' => 'unsubscribed: parameter missing or ill formated'];
      return NULL;
    }

    $unsubscribed = date('Y-m-d H:i:s', $unsubscribed);

    $list_recipient = $this->get($list_id, $list_recipient_id, $to_name, $to_email);
    $this->CI->model_list_recipient->unsubscribe($list_recipient['auto_recipient_id'], $unsubscribed);
    
    return ['200' => 'OK'];
  }
}