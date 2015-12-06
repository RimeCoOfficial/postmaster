<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_message_process
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_message_request');
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

  function get_to_process($count)
  {
    return $this->CI->model_message_request->get_to_process($count);
  }

  function process($messages)
  {
    $message_archive_list = [];
    $message_processed_list = [];
    $message_process_html_list = [];
    
    foreach ($messages as $message)
    {
      if (!empty($message_process_html_list[ $message['message_id'] ]))
      {
        echo 'Already pre-processed HTML: '.$message['message_id'].' (Skipping..)'.PHP_EOL;
      }
      else if (is_null($message['body_html']))
      {
        echo 'Processing HTML message: '.$message['message_id'].PHP_EOL;

        $this->CI->load->library('lib_message');
        if (is_null($this->CI->lib_message->process_html($message['message_id'], $message['subject'], $message['body_html_input'])))
        {
          // raise php error: user_error
          continue;
        }

        $message_process_html_list[ $message['message_id'] ] = TRUE;
      }
      else
      {
        echo '('.$message['request_id'].') Processing message: '.$message['message_id'].' '.$message['subject'].', to: '.$message['to_email'].PHP_EOL;

        $this->CI->load->library('lib_message_request');
        $message_archive_list[] = $this->CI->lib_message_request->process($message);
        $message_processed_list[] = ['request_id' => $message['request_id'], 'processed' => date('Y-m-d H:i:s')];
      }
    }

    if (!empty($message_processed_list))
    {
      $this->CI->db->trans_start();

      // mark processed
      $this->CI->model_message_request->mark_processed($message_processed_list);

      // send message
      $this->CI->load->model('model_message_archive');
      $this->CI->model_message_archive->store($message_archive_list);

      $this->CI->db->trans_complete();
    }

    return TRUE;
  }
}