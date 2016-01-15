<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_message_request
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

  function add($message_id, $owner, $to_name, $to_email, $subject_var, $body_var)
  {
    if (!$this->CI->model_message_request->can_add($message_id, $owner))
    {
      $this->error = ['status' => 401, 'message' => 'invalid message_id'];
      return NULL;
    }

    if (empty($to_name)) $to_name = NULL;

    $subject_var_json = (is_array($subject_var) AND !empty($subject_var)) ? json_encode($subject_var) : NULL;
    $body_var_json    = (is_array($body_var)    AND !empty($body_var))    ? json_encode($body_var)    : NULL;

    return $this->CI->model_message_request->add($message_id, $to_name, $to_email, $subject_var_json, $body_var_json);
  }

  function get_to_process($count)
  {
    return $this->CI->model_message_request->get_to_process($count);
  }

  function process($messages)
  {
    $message_archive_list = [];
    $message_processed_list = [];
    
    foreach ($messages as $message)
    {
      echo '('.$message['request_id'].') Processing message: '.$message['message_id'].' '.$message['subject'].', to: '.$message['to_email'].PHP_EOL;

      $message_archive_list[] = $this->archive($message);
      $message_processed_list[] = ['request_id' => $message['request_id'], 'processed' => date('Y-m-d H:i:s')];
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

  function archive($message)
  {
    $message_archive = $this->init($message);

    $message_archive = $this->parse($message_archive, $message);

    // print_r($message_archive); die();
    return $message_archive;
  }

  private function init($message)
  {
    $message_archive = [];

    $verify_id = random_string('alnum', 64);

    $message_archive['request_id'] = $message['request_id'];
    $message_archive['verify_id'] = $verify_id;
    $message_archive['from_name'] = NULL; // getenv('email_source');
    $message_archive['from_email'] = getenv('email_source');

    $message_archive['to_name'] = $message['to_name'];
    $message_archive['to_email'] = $message['to_email'];

    $message_archive['reply_to_name'] = $message['reply_to_name'];
    $message_archive['reply_to_email'] = $message['reply_to_email'];

    $message_archive['subject'] = $message['subject'];
    $message_archive['body_html'] = $message['body_html'];
    $message_archive['body_text'] = '';

    $message_archive['list_unsubscribe'] = 0;

    $message_archive['priority'] = 0;
    switch ($message['owner'])
    {
      case 'transactional': $message_archive['priority'] = 15; break;
      case 'campaign':      $message_archive['priority'] = 10; break;
      case 'autoresponder': $message_archive['priority'] =  5; break;
      default:                                              break;
    }

    return $message_archive;
  }

  private function parse($message_archive, $message)
  {
    // 4. link-unsubscribe
    // 5. unsubscribe link = request_id + verify_id

    // {unsubscribe} {web_version}

    $default_vars = [
      '_subject' => $message['subject'],
      '_to_email' => $message['to_email'],
      '_to_name' => $message['to_name'],
      '_reply_to_email' => $message['reply_to_email'],
      '_reply_to_name' => $message['reply_to_name'],
      '_unsubscribe_link' => base_url('_unsubscribe_link/'.$message_archive['request_id'].'/'.$message_archive['verify_id']),
      '_web_version_link' => base_url('_web_version_link/'.$message_archive['request_id'].'/'.$message_archive['verify_id']),
      '_current_day' => date('l'),
      '_current_day_number' => date('N'),
      '_current_date' => date('j'),
      '_current_month' => date('F'),
      '_current_month_number' => date('n'),
      '_current_year' => date('Y'),
    ];

    // _campaign_archive_link

    $this->CI->load->library('parser');

    // parse subject
    $subject_vars = !is_null($message['subject_var_json']) ? json_decode($message['subject_var_json'], TRUE) : [];
    $subject_vars = array_merge($subject_vars, $default_vars);
    
    $subject = $this->CI->parser->parse_string($message['subject'],  $subject_vars, TRUE);
    $message_archive['subject'] = $subject;
    $default_vars['_subject'] = $subject;

    // parse body
    $body_vars = !is_null($message['body_var_json']) ? json_decode($message['body_var_json'], TRUE) : [];
    $body_vars = array_merge($body_vars, $default_vars);

    $message_archive['body_html'] = $this->CI->parser->parse_string($message['body_html'],  $body_vars, TRUE);
    $message_archive['body_text'] = $this->CI->parser->parse_string($message['body_text'],  $body_vars, TRUE);

    return $message_archive;
  }
}