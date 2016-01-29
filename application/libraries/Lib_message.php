<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Sunra\PhpSimple\HtmlDomParser;

class Lib_message
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_message');
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

  function get($message_id)
  {
    return $this->CI->model_message->get($message_id);
  }

  function get_list()
  {
    return $this->CI->model_message->get_list();
  }

  function create($subject, $list_id)
  {
    return $this->CI->model_message->create($subject, $list_id);
  }

  function update($message, $subject, $list_id, $body_html_input, $reply_to_name, $reply_to_email)
  {
    if ($message['archived'] != '1000-01-01 00:00:00')
    {
      $this->error = ['message' => 'Didn&#8217;t I told you! The message is archived and can not be modified'];
      return NULL;
    }

    $published_tds = $message['published_tds'];
    if ($list_id != $message['list_id'])  $published_tds = NULL; // back to draft

    if (is_null($result = $this->_process_html($message['message_id'], $body_html_input)))
    {
      return NULL;
    }

    if (empty($reply_to_name)) $reply_to_name = NULL;
    if (empty($reply_to_email)) $reply_to_email = NULL;

    $this->CI->model_message->update(
      $message['message_id'], $subject, $list_id, $published_tds, $body_html_input, $result['body_html'], $result['body_text'], $reply_to_name, $reply_to_email
    );
    
    return $message;
  }

  function publish($message, $php_datetime_str)
  {
    $date_from_str = '1000-01-01 00:00:00';
    $date_from = strtotime($date_from_str);

    switch ($message['type'])
    {
      case 'autoresponder':
      case 'transactional':
        $date_to = strtotime($php_datetime_str, $date_from);
        break;
      
      case 'campaign':
        $date_to = strtotime($php_datetime_str, strtotime('now'));
        break;
    }

    if (!$date_to)
    {
      $this->error = ['message' => 'strtotime returned bool(false). Valid formats are explained in [Date and Time Formats](http://php.net/manual/en/datetime.formats.php).'];
      return NULL;
    }

    // Difference in seconds
    // Autoresponder: +1 day = 86400
    // Campaign:      +1 day = 32064136828
    // Transactional: now = 0
    $diff_in_seconds = $date_to - $date_from;

    $this->CI->model_message->update_publish($message['message_id'], $diff_in_seconds);
    return TRUE;
  }

  function revert($message)
  {
    if ($message['archived'] != '1000-01-01 00:00:00')
    {
      show_error('The message is archived and can not be modified');
    }

    $this->CI->model_message->update_publish($message['message_id'], NULL);
    return TRUE;
  }

  // function archive($message_id, $type)
  // {
  //   $this->CI->model_message->archive($message_id, $type);
  //   return TRUE;
  // }

  // function unarchive($message_id, $type)
  // {
  //   $this->CI->model_message->unarchive($message_id, $type);
  //   return TRUE;
  // }

  function _process_html($message_id, $body_html_input)
  {
    $body_html = $body_html_input;

    // 1. html to text
    $body_text = html_to_text($body_html);

    $dom = HtmlDomParser::str_get_html($body_html);

    // 2. a.target=_blank
    $anchor_url_list = [];
    foreach($dom->find('a') as $anchor)
    {
      $anchor_url_list[] = $anchor->href;
      $anchor->target = '_blank';
    }

    $body_html = $dom->innertext;

    // @todo: 2. GA stats (event: click)
    // Campaign Source    [list]
    // Campaign Name      [message_id]
    // Campaign Medium    email
    // Campaign Content   textlink

    // 3. GA stats (event: open)
    // Version            v=1
    // Tracking ID        tid=UA-XXXXX-Y
    // Client ID          cid=[list_recipient_id]
    // User ID            uid=[user_id]
    // Events             t=event&ec=email&ea=open
    // Campaign Source    cs=[list]  
    // Campaign Medium    cm=email  
    // Campaign Name      cn=[message_id]
    // Document Title     dt=[subject]
    // Document Encoding  de=UTF-8
    $ga_beacon = [
      'v' => 1, 't' => 'event', 'ec' => 'email', 'ea' => 'open',
      'tid' => getenv('ga'),
      'cid' => random_string('md5'),
      'mid' => $message_id
    ];
    $ga_beacon_html = '<img alt="GA" width="1px" height="1px" src="'.'https://www.google-analytics.com/collect?'.http_build_query($ga_beacon).'">';

    $body_html = str_replace('</body>', $ga_beacon_html.'</body>', $body_html, $replace_count);
    if (!$replace_count) $body_html .= $ga_beacon_html;

    // 4. minify html
    $this->CI->load->library('composer/lib_html_minifier');
    $body_html = $this->CI->lib_html_minifier->process($body_html);

    // 5. inline css
    $this->CI->load->library('composer/lib_css_to_inline');
    $body_html = $this->CI->lib_css_to_inline->convert($body_html);

    // 6. add <title>{_subject}</title>
    $body_html = str_replace('</head>', '<title>{_subject}</title>'.'</head>', $body_html);

    // 7. restore href (since urls are encoded by dom in css inline)
    //    {_unsubscribe_link} => %7B_unsubscribe_link%7D
    $dom = HtmlDomParser::str_get_html($body_html);
    $count = 0;
    foreach($dom->find('a') as $anchor)
    {
      $anchor->href = $anchor_url_list[ $count ];
      $count += 1;
    }

    $body_html = $dom->innertext;

    return compact('body_html', 'body_text');
  }

  function add_request($message_id)
  {
    $this->CI->load->library('lib_message_request');

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

    $pseudo_vars = $this->CI->input->post('pseudo_vars');
    
    $message = $this->CI->model_message->get($message_id);
    if ($message['type'] != 'transactional')
    {
      $this->error = ['status' => 401, 'message' => 'the message type is not transactional'];
      return NULL;
    }

    $this->CI->load->library('lib_list_recipient');
    $list_recipient = $this->CI->lib_list_recipient->get($message['list_id'], $list_recipient_id, $to_name, $to_email);

    if (is_null($request_id = $this->CI->lib_message_request->add(
      $message_id, $list_recipient['auto_recipient_id'], $to_name, $to_email, $pseudo_vars)))
    {
      $this->error = $this->CI->lib_message_request->get_error_message();
      return NULL;
    }

    return ['request_id' => $request_id];
  }
}