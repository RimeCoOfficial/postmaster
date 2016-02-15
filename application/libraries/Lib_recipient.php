<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_recipient
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();

    $this->CI->load->model('model_recipient');
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

  function get($list_id, $recipient_id, $to_name = '', $to_email = '')
  {
    $recipient = $this->CI->model_recipient->get($list_id, $recipient_id);

    if (empty($recipient))
    {
      $this->CI->model_recipient->create($list_id, $recipient_id, $to_name, $to_email);
      $recipient = $this->CI->model_recipient->get($list_id, $recipient_id);
    }
    
    return $recipient;
  }

  function get_list($list_id, $count = 99)
  {
    return $this->CI->model_recipient->get_list($list_id, $count);
  }

  function api_verify_input($list_id, $timestamp_param = NULL)
  {
    $recipient_id = $this->CI->input->post('recipient_id');
    if (empty($recipient_id))
    {
      $this->error = ['status' => 401, 'message' => 'missing parameter recipient_id'];
      return NULL;
    }

    $to_name = $this->CI->input->post('to_name');

    if (is_null($to_email = valid_email($this->CI->input->post('to_email'))))
    {
      $this->error = ['status' => 401, 'message' => 'invalid email address in to_email'];
      return NULL;
    }

    $timestamp = $this->CI->input->post($timestamp_param);
    $timestamp = strtotime($timestamp);

    if ($timestamp == FALSE)
    {
      $this->error = ['status' => 401, 'message: timestamp parameter missing or ill formated'];
      return NULL;
    }
    $timestamp = date('Y-m-d H:i:s', $timestamp);

    $result = [
      'recipient_id' => $recipient_id,
      'to_name' => $to_name,
      'to_email' => $to_email,
      'to_name' => $to_name,
      $timestamp_param => $timestamp,
    ];

    if ($timestamp_param = 'metadata_updated')
    {
      $metadata = $this->CI->input->post('metadata');
      $metadata_json = (is_array($metadata) AND !empty($metadata)) ? json_encode($metadata) : NULL;
      $result['metadata_json'] = $metadata_json;
    }

    $recipient = $this->get($list_id, $recipient_id, $to_name, $to_email);
    $result['recipient'] = $recipient;

    return $result;
  }

  function subscribe($list_id)
  {
    if (is_null($result = $this->api_verify_input($list_id, 'subscribed')))
    {
      return NULL;
    }

    $this->CI->model_recipient->subscribe($result['recipient']['auto_recipient_id'], $result['subscribed']);
    return ['200' => 'OK'];
  }

  function unsubscribe($list_id)
  {
    if (is_null($result = $this->api_verify_input($list_id, 'unsubscribed')))
    {
      return NULL;
    }

    $this->CI->model_recipient->unsubscribe($result['recipient']['auto_recipient_id'], $result['unsubscribed']);
    return ['200' => 'OK'];
  }

  function update_metadata($list_id)
  {
    if (is_null($result = $this->api_verify_input($list_id, 'metadata_updated')))
    {
      return NULL;
    }

    $update_other_lists = $this->CI->input->post('update_other_lists');
    if ($update_other_lists == TRUE)
    {
      $update_recipient_id = $result['recipient']['recipient_id'];
    }
    else $update_recipient_id = FALSE;

    $this->CI->model_recipient->update_metadata($result['recipient']['auto_recipient_id'], $result['metadata_json'], $result['metadata_updated'], $update_recipient_id);
    return ['200' => 'OK'];
  }

  function unsubscribe_all($recipient_id, $unsubscribed = '9999-12-31 23:59:59')
  {
    // $unsubscribed = date('Y-m-d H:i:s');

    $this->CI->model_recipient->unsubscribe_all($recipient_id, $unsubscribed);
    return ['200' => 'OK'];
  }
}