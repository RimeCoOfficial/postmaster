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

  function add($message_id, $auto_recipient_id, $to_name, $to_email, $pseudo_vars)
  {
    if (!$this->CI->model_message_request->can_add($message_id))
    {
      $this->error = ['status' => 401, 'message' => 'invalid message_id'];
      return NULL;
    }

    if (empty($to_name)) $to_name = NULL;

    $pseudo_vars_json = (is_array($pseudo_vars) AND !empty($pseudo_vars)) ? json_encode($pseudo_vars) : NULL;

    return $this->CI->model_message_request->add($message_id, $auto_recipient_id, $to_name, $to_email, $pseudo_vars_json);
  }

  function get_to_process($count)
  {
    return $this->CI->model_message_request->get_to_process($count);
  }

  function process($messages)
  {
    $message_archive_list = [];
    $message_processed_list = [];

    $to_email_list = [];
    foreach ($messages as $message) $to_email_list[ $message['to_email'] ] = $message['to_email'];

    $this->CI->load->library('lib_feedback');
    $feedback_list = $this->CI->lib_feedback->get_batch($to_email_list);
    
    foreach ($messages as $message)
    {
      echo '('.$message['request_id'].') Processing message: '.$message['message_id'].' '.$message['subject'].', to: '.$message['to_email'].PHP_EOL;

      // has unsubscribed
      if ($message['unsubscribed'] == '1000-01-01 00:00:00')
      {
        // no bounce
        if (empty($feedback_list[ $message['to_email'] ]) OR $feedback_list[ $message['to_email'] ] != 'bounce')
        {
          $message_archive_list[] = $this->archive($message);
        }
      }

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
    $message_archive = $this->_init($message);

    $message_archive = $this->_parse($message_archive, $message);

    // print_r($message_archive); die();
    return $message_archive;
  }

  private function _init($message)
  {
    $message_archive = [];

    $message_archive['request_id'] = $message['request_id'];
    $message_archive['web_version_key'] = random_string('alnum', 64);
    $message_archive['unsubscribe_key'] = random_string('alnum', 64);
    $message_archive['from_name'] = getenv('app_name');
    $message_archive['from_email'] = getenv('email_source');

    $message_archive['to_name'] = $message['to_name'];
    $message_archive['to_email'] = $message['to_email'];

    // default to name
    if (empty($message_archive['to_name'])) $message_archive['to_name'] = $message['list_recipient_to_name'];

    $message_archive['reply_to_name'] = $message['reply_to_name'];
    $message_archive['reply_to_email'] = $message['reply_to_email'];

    $message_archive['subject'] = $message['subject'];
    $message_archive['body_html'] = $message['body_html'];
    $message_archive['body_text'] = '';

    $message_archive['list_unsubscribe'] = NULL;

    $message_archive['priority'] = 0;
    switch ($message['type'])
    {
      case 'transactional': $message_archive['priority'] = 15; break;
      case 'campaign':      $message_archive['priority'] = 10; break;
      case 'autoresponder': $message_archive['priority'] =  5; break;
      default:                                                 break;
    }

    return $message_archive;
  }

  private function _parse($message_archive, $message)
  {
    $web_version_link = 'open/message/';
    $unsubscribe_link = 'open/unsubscribe?';

    $list_unsubscribe_url = getenv('app_unsubscribe_uri');
    if (empty($list_unsubscribe_url)) $list_unsubscribe_url = base_url($unsubscribe_link);
    else $list_unsubscribe_url = getenv('app_base_url').$list_unsubscribe_url;

    $list_unsubscribe_url .= 'request_id='.$message_archive['request_id'].'&unsubscribe_key='.$message_archive['unsubscribe_key'];
    $list_unsubscribe_url = $message['list_unsubscribe'] ? $list_unsubscribe_url : NULL;

    $default_vars = [
      '_request_id' => $message_archive['request_id'],
      '_subject' => $message['subject'],
      '_list_recipient_id' => $message['list_recipient_id'],
      '_to_email' => $message['to_email'],
      '_to_name' => $message['to_name'],
      '_reply_to_email' => $message['reply_to_email'],
      '_reply_to_name' => $message['reply_to_name'],
      '_web_version_link' => base_url($web_version_link.$message_archive['request_id'].'/'.$message_archive['web_version_key']),
      '_unsubscribe_link' => $list_unsubscribe_url,
      '_current_day' => date('l'),
      '_current_day_number' => date('N'),
      '_current_date' => date('j'),
      '_current_month' => date('F'),
      '_current_month_number' => date('n'),
      '_current_year' => date('Y'),
      '_app_name' => getenv('app_name'),
      '_app_base_url' => getenv('app_base_url'),
    ];

    // _campaign_archive_link

    $this->CI->load->library('parser');

    $pseudo_vars = !is_null($message['pseudo_vars_json']) ? json_decode($message['pseudo_vars_json'], TRUE) : [];
    $pseudo_vars = array_merge($pseudo_vars, $default_vars);

    $metadata = !is_null($message['metadata_json']) ? json_decode($message['metadata_json'], TRUE) : [];
    if (!empty($metadata))
    {
      $pseudo_metadata = [];
      foreach ($metadata as $key => $value) $pseudo_metadata['_metadata_'.$key] = $value;

      $pseudo_vars = array_merge($pseudo_vars, $pseudo_metadata);
    }
    
    // parse subject
    $subject = $this->CI->parser->parse_string($message['subject'],  $pseudo_vars, TRUE);
    $message_archive['subject'] = $subject;
    
    $pseudo_vars['_subject'] = $subject;

    // parse body
    $message_archive['body_html'] = $this->CI->parser->parse_string($message['body_html'],  $pseudo_vars, TRUE);
    $message_archive['body_text'] = $this->CI->parser->parse_string($message['body_text'],  $pseudo_vars, TRUE);

    $message_archive['list_unsubscribe'] = $list_unsubscribe_url;

    return $message_archive;
  }
}