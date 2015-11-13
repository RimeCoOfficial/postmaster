<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_label
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_label');
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

  function get($label_id)
  {
    return $this->CI->model_label->get($label_id);
  }

  function get_list()
  {
    return $this->CI->model_label->get_list();
  }

  function create($name)
  {
    if ( ! $this->CI->model_label->is_available($name))
    {
      $this->error = ['message' => 'label: "'.$name.'" has already beed created, pick a different name'];
      return NULL;
    }

    return $this->CI->model_label->create($name);
  }

  function modify($label_id, $name)
  {
    if ( ! $this->CI->model_label->is_available($name, $label_id))
    {
      $this->error = ['message' => 'label: "'.$name.'" has already beed created, pick a different name'];
      return NULL;
    }

    $this->CI->model_label->modify($label_id, $name);
    return TRUE;
  }

  function delete($label_id)
  {
    return $this->CI->model_label->delete($label_id);
  }
}