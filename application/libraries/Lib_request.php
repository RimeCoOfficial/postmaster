<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_request
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_request');
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
    if (!$this->CI->model_request->can_add($message_id))
    {
      $this->error = ['status' => 401, 'message' => 'invalid message_id'];
      return NULL;
    }

    if (empty($to_name)) $to_name = NULL;

    $pseudo_vars_json = (is_array($pseudo_vars) AND !empty($pseudo_vars)) ? json_encode($pseudo_vars) : NULL;

    return $this->CI->model_request->add($message_id, $auto_recipient_id, $to_name, $to_email, $pseudo_vars_json);
  }

  function get_to_process($count)
  {
    return $this->CI->model_request->get_to_process($count);
  }

  function process($messages)
  {
    $archive_list = [];
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
          $archive_list[] = $this->archive($message);
        }
      }

      $message_processed_list[] = ['request_id' => $message['request_id'], 'processed' => date('Y-m-d H:i:s')];
    }

    if (!empty($message_processed_list))
    {
      $this->CI->db->trans_start();

      // mark processed
      $this->CI->model_request->mark_processed($message_processed_list);

      // send message
      $this->CI->load->model('model_archive');
      $this->CI->model_archive->store($archive_list);

      $this->CI->db->trans_complete();
    }

    return TRUE;
  }

  function archive($message)
  {
    $archive = $this->_init($message);

    $archive = $this->_parse($archive, $message);

    // print_r($archive); die();
    return $archive;
  }

  private function _init($message)
  {
    $archive = [];

    $archive['request_id'] = $message['request_id'];
    $archive['web_version_key'] = random_string('alnum', 64);
    $archive['unsubscribe_key'] = random_string('alnum', 64);
    $archive['from_name'] = getenv('app_name');
    $archive['from_email'] = getenv('email_source');

    $archive['to_name'] = $message['to_name'];
    $archive['to_email'] = $message['to_email'];

    // default to name
    if (empty($archive['to_name'])) $archive['to_name'] = $message['recipient_to_name'];

    $archive['reply_to_name'] = $message['reply_to_name'];
    $archive['reply_to_email'] = $message['reply_to_email'];

    $archive['subject'] = $message['subject'];
    $archive['body_html'] = $message['body_html'];
    $archive['body_text'] = '';

    $archive['list_unsubscribe'] = NULL;

    $archive['priority'] = 0;
    switch ($message['type'])
    {
      case 'transactional': $archive['priority'] = 15; break;
      case 'campaign':      $archive['priority'] = 10; break;
      case 'autoresponder': $archive['priority'] =  5; break;
      default:                                                 break;
    }

    return $archive;
  }

  private function _parse($archive, $message)
  {
    $web_version_link = 'open/message/';
    $unsubscribe_link = 'open/unsubscribe?';

    $list_unsubscribe_url = getenv('app_unsubscribe_uri');
    if (empty($list_unsubscribe_url)) $list_unsubscribe_url = base_url($unsubscribe_link);
    else $list_unsubscribe_url = getenv('app_base_url').$list_unsubscribe_url;

    $list_unsubscribe_url .= 'request_id='.$archive['request_id'].'&unsubscribe_key='.$archive['unsubscribe_key'];
    $list_unsubscribe_url = $message['list_unsubscribe'] ? $list_unsubscribe_url : NULL;

    $default_vars = [
      '_request_id' => $archive['request_id'],
      '_subject' => $message['subject'],
      '_recipient_id' => $message['recipient_id'],
      '_to_email' => $message['to_email'],
      '_to_name' => $message['to_name'],
      '_reply_to_email' => $message['reply_to_email'],
      '_reply_to_name' => $message['reply_to_name'],
      '_web_version_link' => base_url($web_version_link.$archive['request_id'].'/'.$archive['web_version_key']),
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
    
    // parse subject
    $subject = $this->CI->parser->parse_string($message['subject'],  $pseudo_vars, TRUE);
    $archive['subject'] = $subject;
    
    $pseudo_vars['_subject'] = $subject;

    // parse body
    $archive['body_html'] = $this->CI->parser->parse_string($message['body_html'],  $pseudo_vars, TRUE);
    $archive['body_text'] = $this->CI->parser->parse_string($message['body_text'],  $pseudo_vars, TRUE);

    $archive['list_unsubscribe'] = $list_unsubscribe_url;

    return $archive;
  }
}