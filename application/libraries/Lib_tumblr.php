<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_tumblr
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

  function get_error_message()
  {}

  function get_access_token()
  {}

  private function _store_token($service, $x_account_id, $token, $token_secret)
  {}

  function post($subject, $body_html)
  {
    $default_vars = [
      '_subject' => $subject,
      '_current_day' => date('l'),
      '_current_day_number' => date('N'),
      '_current_date' => date('j'),
      '_current_month' => date('F'),
      '_current_month_number' => date('n'),
      '_current_year' => date('Y'),
    ];
    
    $this->CI->load->library('parser');

    // parse subject
    $subject = $this->CI->parser->parse_string($subject, $default_vars, TRUE);
    $default_vars['_subject'] = $subject;

    // parse body html
    $body_html = $this->CI->parser->parse_string($body_html, $default_vars, TRUE);

    // $options = array(
    //   'form_params' => ['type' => 'text', 'title' => $title, 'body' => $body, 'tags' => $tags]
    // );

    // if (is_null($response = $this->fetch($this->api_base_path.'/blog/'.$short_name.'.tumblr.com/post', $options, 'POST', 201)))
    // {
    //   return NULL;
    // }

    // if (empty($response['response']['id']))
    // {
    //   $this->error = array('message' => 'post id not found');
    //   return NULL;
    // }
    // return $response['response']['id'];

    // @todo: store post_id

    return $post_id;
  }
}