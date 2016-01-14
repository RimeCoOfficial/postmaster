<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

  function create($owner, $subject, $published = '1000-01-01 00:00:00')
  {
    return $this->CI->model_message->create($owner, $subject, $published);
  }

  function modify($message_id, $owner, $subject, $published, $body_html_input, $reply_to_name, $reply_to_email)
  {
    if (is_null($result = $this->_process_html($message_id, $body_html_input)))
    {
      return NULL;
    }

    if (empty($reply_to_name)) $reply_to_name = NULL;
    if (empty($reply_to_email)) $reply_to_email = NULL;

    $this->CI->model_message->update(
      $message_id, $owner, $subject, $published, $body_html_input, $result['body_html'], $result['body_text'], $reply_to_name, $reply_to_email
    );
    return TRUE;
  }

  function archive($message_id, $owner)
  {
    $this->CI->model_message->archive($message_id, $owner);
  }

  function unarchive($message_id, $owner)
  {
    $this->CI->model_message->unarchive($message_id, $owner);
  }

  function _process_html($message_id, $body_html_input)
  {
    $body_html = $body_html_input;

    // 1. body_text
    $body_text = $this->body_html_to_text($body_html);

    libxml_use_internal_errors(TRUE);
    $doc = new DOMDocument();
    $doc->loadHTML($body_html);

    // 2. a.target=_blank
    $a_tags = $doc->getElementsByTagName('a');
    foreach ($a_tags as $a_element) $a_element->setAttribute('target', '_blank');

    $body_html = $doc->saveHtml();

    // 3. GA stats
    // [![Analytics](https://ga-beacon.appspot.com/UA-XXXXX-X/your-repo/page-name)](https://github.com/igrigorik/ga-beacon)
    // @todo: campaign vars
    $ga_node_url = 'http://ga-beacon.appspot.com/'.getenv('ga').'/message-'.$message_id.'?pixel';

    $ga_node = $doc->createElement('img');
    $ga_node->setAttribute('src', $ga_node_url);
    $ga_node->setAttribute('alt', 'GA');

    $body_element = $doc->getElementsByTagName('body')->item(0);
    if (!empty($body_element))  $body_element->appendChild($ga_node);
    else                        $doc->appendChild($ga_node);

    $body_html = $doc->saveHtml();

    // 4. minify html
    // $this->CI->load->library('composer/lib_html_minifier');
    // $body_html = $this->CI->lib_html_minifier->process($body_html);

    // 5. inline css
    $this->CI->load->library('composer/lib_css_to_inline');
    $body_html = $this->CI->lib_css_to_inline->convert($body_html);

    // $body_text = $this->body_html_to_text($body_html);

    return compact('body_html', 'body_text');
  }

  private function DOMinnerHTML(DOMNode $element) 
  { 
    $innerHTML = '';
    $children  = $element->childNodes;

    foreach ($children as $child) $innerHTML .= $element->ownerDocument->saveHTML($child);

    return $innerHTML; 
  }

  private function body_html_to_text($html)
  {
    libxml_use_internal_errors(TRUE);
    $doc = new DOMDocument();
    $doc->loadHTML($html);

    $text_area_div = $doc->getElementById('text-area');
    if (!is_null($text_area_div))
    {
      $html = $this->DOMinnerHTML($text_area_div);
    }

    // $this->CI->load->library('composer/lib_html_to_markdown');
    // $text = $this->CI->lib_html_to_markdown->convert($html);

    // $this->CI->load->library('composer/lib_html_minifier');
    // $html = $this->CI->lib_html_minifier->process($html);

    $text = strip_tags($html);

    // http://stackoverflow.com/a/2368546
    $text = preg_replace('!\s+!', ' ', $text); // or '/\s+/'

    $text = trim($text);

    return $text;
  }
}