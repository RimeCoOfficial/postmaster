<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_message_history
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_message_history');
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

  function add($message_id, $owner, $to_name, $to_email, $subject_var, $body_var)
  {
    if (!$this->CI->model_message_history->can_add($message_id, $owner))
    {
      $this->error = ['status' => 401, 'message' => 'invalid message_id'];
      return NULL;
    }

    if (empty($to_name)) $to_name = NULL;

    $subject_var_json = (is_array($subject_var) AND !empty($subject_var)) ? json_encode($subject_var) : NULL;
    $body_var_json    = (is_array($body_var)    AND !empty($body_var))    ? json_encode($body_var)    : NULL;

    return $this->CI->model_message_history->add($message_id, $to_name, $to_email, $subject_var_json, $body_var_json);
  }

  function get_to_process($count)
  {
    return $this->CI->model_message_history->get_to_process($count);
  }

  function process($messages)
  {
    $message_send_list = [];
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
        echo '('.$message['history_id'].') Processing message: '.$message['message_id'].' '.$message['subject'].', to: '.$message['to_email'].PHP_EOL;

        $this->CI->load->library('lib_message_history_process');
        $message_send_list[] = $this->CI->lib_message_history_process->process($message);
        $message_processed_list[] = ['history_id' => $message['history_id'], 'processed' => date('Y-m-d H:i:s')];
      }
    }

    if (!empty($message_processed_list))
    {
      $this->CI->db->trans_start();

      // mark processed
      $this->CI->model_message_history->mark_processed($message_processed_list);

      // send message
      $this->CI->load->model('model_message_send');
      $this->CI->model_message_send->store($message_send_list);

      $this->CI->db->trans_complete();
    }

    return TRUE;
  }
}