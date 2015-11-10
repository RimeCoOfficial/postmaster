<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_transactional
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_transactional');
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

  function get_category_list()
  {
    return $this->CI->model_transactional->get_category_list();
  }

  function create_category($category, $reply_to_name = NULL, $reply_to_email = NULL)
  {
    if ( ! $this->CI->model_transactional->is_category_available($category))
    {
      $this->error = ['message' => 'category: "'.$category.'" has already beed created, pick a different name'];
      return NULL;
    }

    if (empty($reply_to_name)) $reply_to_name = NULL;
    if (empty($reply_to_email)) $reply_to_email = NULL;

    $this->CI->model_transactional->create_category($category, $reply_to_name, $reply_to_email);
    return TRUE;
  }
}