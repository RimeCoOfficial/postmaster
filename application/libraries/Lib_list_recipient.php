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

  function api_verify_input($list_id, $method = NULL)
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

    $result = [];
    $result['list_recipient_id'] = $list_recipient_id;
    $result['to_name'] = $to_name;
    $result['to_email'] = $to_email;
    $result['to_name'] = $to_name;

    $timestamp_param = NULL;
    switch ($method)
    {
      case 'subscribe': $timestamp_param = 'subscribed'; break;
      case 'unsubscribe': $timestamp_param = 'unsubscribed'; break;
      case 'update_metadata':
        $timestamp_param = 'metadata_updated';

        $metadata = $this->CI->input->post('metadata');
        $metadata_json = (is_array($metadata) AND !empty($metadata)) ? json_encode($metadata) : NULL;
        $result['metadata_json'] = $metadata_json;

        break;
    }

    $timestamp = $this->CI->input->post($timestamp_param);
    $timestamp = strtotime($timestamp);

    if ($timestamp == FALSE)
    {
      $this->error = ['status' => 401, 'message' => $timestamp_param.': parameter missing or ill formated'];
      return NULL;
    }

    $timestamp = date('Y-m-d H:i:s', $timestamp);
    $result[ $timestamp_param ] = $timestamp;

    $list_recipient = $this->get($list_id, $list_recipient_id, $to_name, $to_email);
    $result['list_recipient'] = $list_recipient;

    return $result;
  }

  function subscribe($list_id)
  {
    if (is_null($result = $this->api_verify_input($list_id, 'subscribe')))
    {
      return NULL;
    }

    $this->CI->model_list_recipient->subscribe($result['list_recipient']['auto_recipient_id'], $result['subscribed']);
    return ['200' => 'OK'];
  }

  function unsubscribe($list_id)
  {
    if (is_null($result = $this->api_verify_input($list_id, 'unsubscribe')))
    {
      return NULL;
    }

    $this->CI->model_list_recipient->unsubscribe($result['list_recipient']['auto_recipient_id'], $result['unsubscribed']);
    return ['200' => 'OK'];
  }

  function update_metadata($list_id)
  {
    if (is_null($result = $this->api_verify_input($list_id, 'update_metadata')))
    {
      return NULL;
    }

    $update_other_lists = $this->CI->input->post('update_other_lists');
    if ($update_other_lists == TRUE)
    {
      $update_list_recipient_id = $result['list_recipient']['list_recipient_id'];
    }
    else $update_list_recipient_id = FALSE;

    $this->CI->model_list_recipient->update_metadata($result['list_recipient']['auto_recipient_id'], $result['metadata_json'], $result['metadata_updated'], $update_list_recipient_id);
    return ['200' => 'OK'];
  }
}