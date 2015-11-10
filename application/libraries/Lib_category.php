<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_category
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_category');
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

  function get($category_id)
  {
    return $this->CI->model_category->get($category_id);
  }

  function get_list()
  {
    return $this->CI->model_category->get_list();
  }

  function create($name)
  {
    if ( ! $this->CI->model_category->is_available($name))
    {
      $this->error = ['message' => 'category: "'.$name.'" has already beed created, pick a different name'];
      return NULL;
    }

    return $this->CI->model_category->create($name);
  }

  function modify($category_id, $name)
  {
    if ( ! $this->CI->model_category->is_available($name, $category_id))
    {
      $this->error = ['message' => 'category: "'.$name.'" has already beed created, pick a different name'];
      return NULL;
    }

    $this->CI->model_category->modify($category_id, $name);
    return TRUE;
  }
}