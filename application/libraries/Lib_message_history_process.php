<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_message_history_process
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
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

  private function init($message)
  {
    $message_send = [];

    $verify_id = random_string('alnum', 64);

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
    $message_send['body_text'] = '';

    $message_send['list_unsubscribe'] = 0;

    $message_send['priority'] = 0;
    switch ($message['owner'])
    {
      case 'transaction':   $message_send['priority'] = 15; break;
      case 'campaign':      $message_send['priority'] = 10; break;
      case 'autoresponder': $message_send['priority'] =  5; break;
      default:                                              break;
    }

    return $message_send;
  }

  private function parse($message_send, $message)
  {
    // 4. link-unsubscribe
    // 5. unsubscribe link = history_id + verify_id

    // {unsubscribe} {web_version}

    $default_vars = [
      '_subject' => $message['subject'],
      '_to_email' => $message['to_email'],
      '_to_name' => $message['to_name'],
      '_reply_to_email' => $message['reply_to_email'],
      '_reply_to_name' => $message['reply_to_name'],
      '_tumblr_post_link' => $message['tumblr_post_id'],
      '_unsubscribe_link' => base_url('_unsubscribe_link/'.$message_send['history_id'].'/'.$message_send['verify_id']),
      '_web_version_link' => base_url('_web_version_link/'.$message_send['history_id'].'/'.$message_send['verify_id']),
      '_current_day' => date('l'),
      '_current_day_number' => date('N'),
      '_current_date' => date('j'),
      '_current_month' => date('F'),
      '_current_month_number' => date('n'),
      '_current_year' => date('Y'),
    ];

    $this->CI->load->library('parser');

    // parse subject
    $subject_vars = !is_null($message['subject_var_json']) ? json_decode($message['subject_var_json'], TRUE) : [];
    $subject_vars = array_merge($subject_vars, $default_vars);
    
    $subject = $this->CI->parser->parse_string($message['subject'],  $subject_vars, TRUE);
    $message_send['subject'] = $subject;
    $default_vars['_subject'] = $subject;

    // parse body
    $body_vars = !is_null($message['body_var_json']) ? json_decode($message['body_var_json'], TRUE) : [];
    $body_vars = array_merge($body_vars, $default_vars);

    $message_send['body_html'] = $this->CI->parser->parse_string($message['body_html'],  $body_vars, TRUE);

    return $message_send;
  }

  private function DOMinnerHTML(DOMNode $element) 
  { 
    $innerHTML = '';
    $children  = $element->childNodes;

    foreach ($children as $child) $innerHTML .= $element->ownerDocument->saveHTML($child);

    return $innerHTML; 
  }

  private function body_text($html)
  {
    libxml_use_internal_errors(TRUE);
    $doc = new DOMDocument();
    $doc->loadHTML($html);

    $body_div = $doc->getElementById('body');
    if (!is_null($body_div))
    {
      $body_div_html = $this->DOMinnerHTML($body_div);

      $footer_div = $doc->getElementById('footer');
      if (!is_null($footer_div))
      {
        $html = $this->DOMinnerHTML($footer_div);
      }

      $html = $body_div_html.(!empty($html) ? "<br><hr>".$html : '');
    }

    $this->CI->load->library('composer/lib_html_to_markdown');
    $text = $this->CI->lib_html_to_markdown->convert($html);

    return $text;
  }

  function process($message)
  {
    $message_send = $this->init($message);

    $message_send = $this->parse($message_send, $message);

    $message_send['body_text'] = $this->body_text($message_send['body_html']);

    // print_r($message_send); die();
    return $message_send;
  }
}