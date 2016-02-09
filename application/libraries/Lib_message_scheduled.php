<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_message_scheduled
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_message_scheduled');
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

  function get_autoresponder_recipients($count)
  {
    return $this->CI->model_message_scheduled->get_autoresponder_recipients($count);
  }

  function process_autoresponders($list_recipients)
  {
    $request_list = [];
    
    foreach ($list_recipients as $list_recipient)
    {
      $pseudo_vars = [];
      if (!is_null($list_recipient['metadata_json']))
      {
        $metadata = json_decode($list_recipient['metadata_json'], TRUE);
        if (!empty($metadata)) foreach ($metadata as $key => $value) $pseudo_vars['_metadata_'.$key] = $value;
      }

      $pseudo_vars_json = !empty($pseudo_vars) ? json_encode($pseudo_vars) : NULL;

      echo "\t".'Autoresponder #'.$list_recipient['message_id'].', to_email: '.$list_recipient['to_email'].PHP_EOL;

      // message_id, auto_recipient_id, to_name, to_email, pseudo_vars_json
      $request_list[] = [
        'message_id' => $list_recipient['message_id'],
        'auto_recipient_id' => $list_recipient['auto_recipient_id'],
        'to_name' => $list_recipient['to_name'],
        'to_email' => $list_recipient['to_email'],
        'pseudo_vars_json' => $pseudo_vars_json,
      ];
    }

    $this->CI->load->model('model_message_request');
    $this->CI->model_message_request->add_batch($request_list);
    return TRUE;
  }

  function get_latest_campaign()
  {
    return $this->CI->model_message_scheduled->get_latest_campaign();
  }

  function process_campaign($message, $count)
  {
    $list_recipients = $this->CI->model_message_scheduled->get_campaign_recipients($message['message_id'], $message['list_id'], $count);

    if (empty($list_recipients))
    {
      echo "\t".'Campaign #'.$message['message_id'].', archiving...'.PHP_EOL;

      $this->CI->load->library('lib_message');
      $this->CI->lib_message->archive($message['message_id'], $message['type']);
      return TRUE;
    }

    $request_list = [];
    
    foreach ($list_recipients as $list_recipient)
    {
      $pseudo_vars = [];
      if (!is_null($list_recipient['metadata_json']))
      {
        $metadata = json_decode($list_recipient['metadata_json'], TRUE);
        if (!empty($metadata)) foreach ($metadata as $key => $value) $pseudo_vars['_metadata_'.$key] = $value;
      }

      $pseudo_vars_json = !empty($pseudo_vars) ? json_encode($pseudo_vars) : NULL;

      echo "\t".'Campaign #'.$message['message_id'].', to_email: '.$list_recipient['to_email'].PHP_EOL;

      // message_id, auto_recipient_id, to_name, to_email, pseudo_vars_json
      $request_list[] = [
        'message_id' => $message['message_id'],
        'auto_recipient_id' => $list_recipient['auto_recipient_id'],
        'to_name' => $list_recipient['to_name'],
        'to_email' => $list_recipient['to_email'],
        'pseudo_vars_json' => $pseudo_vars_json,
      ];
    }

    $this->CI->load->model('model_message_request');
    $this->CI->model_message_request->add_batch($request_list);
    return TRUE;
  }
}
