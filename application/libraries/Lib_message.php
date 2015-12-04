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
    if (empty($reply_to_name)) $reply_to_name = NULL;
    if (empty($reply_to_email)) $reply_to_email = NULL;

    $this->CI->model_message->update($message_id, $owner, $subject, $published, $body_html_input, $reply_to_name, $reply_to_email);
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

  function process_html($message_id, $subject, $body_html_input, $post_to_tumblr = 0)
  {
    $body_html = $body_html_input;

    libxml_use_internal_errors(TRUE);
    $doc = new DOMDocument();
    $doc->loadHTML($body_html);

    // 1. attachment inline-image=img.src file=a.href
    $url_list = [];
    $a_tags = $doc->getElementsByTagName('a');
    foreach ($a_tags as $a_element)
    {
      $href = $a_element->getAttribute('href'); $url_list[ $href ] = $href;
    }

    $img_tags = $doc->getElementsByTagName('img');
    foreach ($img_tags as $img_element)
    {
      $src = $img_element->getAttribute('src'); $url_list[ $src ] = $src;
    }

    if (!empty($url_list))
    {
      $this->CI->load->library('lib_s3_object');
      if (is_null($attachments = $this->CI->lib_s3_object->attach($url_list)))
      {
        $this->error = $this->CI->lib_s3_object->get_error_message();
        return NULL;
      }

      if (!empty($attachments))
      {
        // loop and update the urls
        foreach ($a_tags as $a_element)
        {
          $href = $a_element->getAttribute('href');
          if (!empty($attachments[ $href ])) $a_element->setAttribute('href', $attachments[ $href ]);
        }

        foreach ($img_tags as $img_element)
        {
          $src = $img_element->getAttribute('src');
          if (!empty($attachments[ $src ])) $img_element->setAttribute('src', $attachments[ $src ]);
        }

        $body_html_input = $doc->saveHtml();
      }
    }

    // 2. a.target=_blank
    $a_tags = $doc->getElementsByTagName('a');
    foreach ($a_tags as $a_element) $a_element->setAttribute('target', '_blank');

    $body_html = $doc->saveHtml();

    // 3. post to tumblr
    if ($post_to_tumblr)
    {
      $this->CI->load->library('lib_tumblr');
      if (is_null($this->CI->lib_tumblr->post($subject, $body_html)))
      {
        $this->error = $this->CI->lib_tumblr->get_error_message();
        return NULL;
      }
    }

    // 4. GA stats
    $ga_node_url = base_url('ga/{message_id}'); // @todo: campaign vars

    $ga_node = $doc->createElement('img');
    $ga_node->setAttribute('src', $ga_node_url);
    $ga_node->setAttribute('alt', 'GA');

    $body_tag = $doc->getElementsByTagName('body')->item(0);
    $body_element = $body_tag[0];
    if (!empty($body_element))  $body_element->appendChild($ga_node);
    else                        $doc->appendChild($ga_node);

    $body_html = $doc->saveHtml();

    // 5. minify html
    $this->CI->load->library('composer/lib_html_minifier');
    $body_html = $this->CI->lib_html_minifier->process($body_html);

    // 6. inline css
    // @todo: download css file async
    $this->CI->load->library('composer/lib_css_to_inline');
    $body_html = $this->CI->lib_css_to_inline->convert($body_html);

    // echo $body_html; die();

    $this->CI->model_message->update_html($message_id, $body_html_input, $body_html);
    return TRUE;
  }
}