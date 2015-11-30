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

  function add($owner, $message_id, $to_name, $to_email, $subject, $body)
  {
    if (!$this->CI->model_message_history->can_add($message_id, $owner))
    {
      $this->error = ['status' => 401, 'message' => 'invalid message_id'];
      return NULL;
    }

    if (empty($to_name)) $to_name = NULL;
    if (empty($subject)) $subject = NULL;
    if (empty($body)) $body = NULL;

    return $this->CI->model_message_history->add($message_id, $to_name, $to_email, $subject, $body);
  }

  function get_to_process($count)
  {
    return $this->CI->model_message_history->get_to_process($count);
  }

  function process($messages)
  {
    $message_send_list = [];
    $message_processed_list = [];

    foreach ($messages as $message)
    {
      echo '('.$message['history_id'].') Processing message: '.$message['message_id'].' '.$message['subject'].', to: '.$message['to_email'].PHP_EOL;

      $verify_id = random_string('alnum', 64);

      $message_send = [];

      $message_send['history_id'] = $message['history_id'];
      $message_send['verify_id'] = $verify_id;
      $message_send['from_name'] = NULL; // getenv('email_source');
      $message_send['from_email'] = getenv('email_source');

      $message_send['to_name'] = $message['to_name'];
      $message_send['to_email'] = $message['to_email'];

      $message_send['reply_to_name'] = $message['reply_to_name'];
      $message_send['reply_to_email'] = $message['reply_to_email'];

      $message_send['subject'] = $message['subject'];
      $message_send['body_html'] = $message['body_html'];
      $message_send['body_text'] = 'o.O'; // $message['body_text'];

      $message_send['list_unsubscribe'] = 0;

      $message_send['priority'] = 0;
      switch ($message['owner']) {
        case 'transaction':   $message_send['priority'] = 15; break;
        case 'campaign':      $message_send['priority'] = 10; break;
        case 'autoresponder': $message_send['priority'] =  5; break;
        default: break;
      }

      // 1.  replace vars: subject, body_html
      // 2.  body_txt
      // 3.  attachment
      // 4.  link-unsubscribe
      // 4.1 unsubscribe link using verify_id
      // 5.  GA stats

      // var_dump($message_send); die();

      $message_send_list[] = $message_send;
      $message_processed_list[] = ['history_id' => $message['history_id'], 'processed' => date('Y-m-d H:i:s')];
    }

    $this->CI->db->trans_start();

    // mark processed
    $this->CI->model_message_history->mark_processed($message_processed_list);

    // send message
    $this->CI->load->model('model_message_send');
    $this->CI->model_message_send->store($message_send_list);

    $this->CI->db->trans_complete();

    return TRUE;
  }
}