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

  function modify($message_id, $subject, $body_html, $reply_to_name, $reply_to_email)
  {
    if (empty($reply_to_name)) $reply_to_name = NULL;
    if (empty($reply_to_email)) $reply_to_email = NULL;

    $body_html_min = $body_html;

    $this->CI->load->library('composer/lib_html_minifier');
    $body_html_min = $this->CI->lib_html_minifier->process($body_html_min);

    $this->CI->load->library('composer/lib_css_to_inline');
    $body_html_min = $this->CI->lib_css_to_inline->convert($body_html_min);

    $this->CI->model_message->update($message_id, $subject, $body_html, $body_html_min,$reply_to_name, $reply_to_email);
    return TRUE;
  }

  function archive($message_id)
  {
    $this->CI->model_message->archive($message_id);
  }
}