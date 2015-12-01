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

  function create($owner, $subject)
  {
    $this->CI->db->trans_start();
    $message_id = $this->CI->model_message->create($owner, $subject);

    $model_owner = 'model_'.$owner;
    $this->CI->load->model($model_owner);
    $this->CI->$model_owner->create($message_id);

    $this->CI->db->trans_complete();

    return $message_id;
  }

  function modify($message_id, $subject, $body_html_ori, $reply_to_name, $reply_to_email)
  {
    if (empty($reply_to_name)) $reply_to_name = NULL;
    if (empty($reply_to_email)) $reply_to_email = NULL;

    $this->CI->model_message->update($message_id, $subject, $body_html_ori, $reply_to_name, $reply_to_email);
    return TRUE;
  }

  function archive($message_id)
  {
    $this->CI->model_message->archive($message_id);
  }

  function process_html($message_id, $body_html)
  {
    // 1. minify html
    $this->CI->load->library('composer/lib_html_minifier');
    $body_html = $this->CI->lib_html_minifier->process($body_html);

    // 2. inline css
    $this->CI->load->library('composer/lib_css_to_inline');
    $body_html = $this->CI->lib_css_to_inline->convert($body_html);

    // 3. a.target=_blank
    libxml_use_internal_errors(TRUE);
    $doc = new DOMDocument();
    $doc->loadHTML($body_html);

    $a_tags = $doc->getElementsByTagName('a');
    foreach ($a_tags as $a_element)
    {
      $href = $a_element->getAttribute('href');

      $a_element->setAttribute('target', '_blank');
    }

    // 4. attachment inline-image=img.src file=a.href

    // 5. GA stats
    $ga_node_url = base_url('ga/{message_id}'); // @todo: campaign vars

    $ga_node = $doc->createElement('img');
    $ga_node->setAttribute('src', $ga_node_url);
    $ga_node->setAttribute('alt', 'GA');

    $body_tag = $doc->getElementsByTagName('body');
    $body_element = $body_tag[0];
    if (!empty($body_element))  $body_element->appendChild($ga_node);
    else                        $doc->appendChild($ga_node);

    $body_html = $doc->saveHtml();
    // echo $body_html; die();

    $this->CI->model_message->update_html($message_id, $body_html);
    return true;
  }
}