<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_request_scheduled
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_request_scheduled');
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
    return $this->CI->model_request_scheduled->get_autoresponder_recipients($count);
  }

  function process_autoresponders($recipients)
  {
    $request_list = [];
    
    foreach ($recipients as $recipient)
    {
      $pseudo_vars = [];
      if (!is_null($recipient['metadata_json']))
      {
        $metadata = json_decode($recipient['metadata_json'], TRUE);
        if (!empty($metadata)) foreach ($metadata as $key => $value) $pseudo_vars['_metadata_'.$key] = $value;
      }

      $pseudo_vars_json = !empty($pseudo_vars) ? json_encode($pseudo_vars) : NULL;

      echo "\t".'Autoresponder #'.$recipient['message_id'].', to_email: '.$recipient['to_email'].PHP_EOL;

      // message_id, auto_recipient_id, to_name, to_email, pseudo_vars_json
      $request_list[] = [
        'message_id' => $recipient['message_id'],
        'auto_recipient_id' => $recipient['auto_recipient_id'],
        'to_name' => $recipient['to_name'],
        'to_email' => $recipient['to_email'],
        'pseudo_vars_json' => $pseudo_vars_json,
      ];
    }

    $this->CI->load->model('model_request');
    $this->CI->model_request->add_batch($request_list);
    return TRUE;
  }

  function get_latest_campaign()
  {
    return $this->CI->model_request_scheduled->get_latest_campaign();
  }

  function process_campaign($message, $count)
  {
    $recipients = $this->CI->model_request_scheduled->get_campaign_recipients($message['message_id'], $message['list_id'], $count);

    if (empty($recipients))
    {
      $message_id = $message['message_id'];
      echo "\t".'Campaign #'.$message_id.', archiving...'.PHP_EOL;

      $objects = [];
      $objects[ $message_id.'-html' ] = [
        'key' => 'messages/'.$message_id.'-'.md5($message['list_id']).md5($message['created']).'.html',
        'body' => $message['body_html'],
        'content-type' => 'text/html',
      ];

      $objects[ $message_id.'-text' ] = [
        'key' => 'messages/'.$message_id.'-'.md5($message['list_id']).md5($message['created']).'.txt',
        'body' => $message['body_text'],
        'content-type' => 'text/plain',
      ];

      $this->CI->load->library('lib_s3_object');
      if (is_null($results = $this->CI->lib_s3_object->upload_async($objects)))
      {
        $this->error = $this->CI->lib_s3_object->get_error_message();
        return NULL;
      }

      if (!empty($results))
      {
        if (!empty($results[ $message_id.'-html' ]) AND !empty($results[ $message_id.'-text' ]))
        {
          $this->CI->load->library('lib_message');
          $this->CI->model_message->archive($message_id);
        }
      }

      $this->error = $this->CI->lib_s3_object->get_error_message();
      if (!empty($this->error)) return NULL;
      else                      return TRUE;
    }

    $request_list = [];
    
    foreach ($recipients as $recipient)
    {
      $pseudo_vars = [];
      if (!is_null($recipient['metadata_json']))
      {
        $metadata = json_decode($recipient['metadata_json'], TRUE);
        if (!empty($metadata)) foreach ($metadata as $key => $value) $pseudo_vars['_metadata_'.$key] = $value;
      }

      $pseudo_vars_json = !empty($pseudo_vars) ? json_encode($pseudo_vars) : NULL;

      echo "\t".'Campaign #'.$message['message_id'].', to_email: '.$recipient['to_email'].PHP_EOL;

      // message_id, auto_recipient_id, to_name, to_email, pseudo_vars_json
      $request_list[] = [
        'message_id' => $message['message_id'],
        'auto_recipient_id' => $recipient['auto_recipient_id'],
        'to_name' => $recipient['to_name'],
        'to_email' => $recipient['to_email'],
        'pseudo_vars_json' => $pseudo_vars_json,
      ];
    }

    $this->CI->load->model('model_request');
    $this->CI->model_request->add_batch($request_list);
    return TRUE;
  }
}
