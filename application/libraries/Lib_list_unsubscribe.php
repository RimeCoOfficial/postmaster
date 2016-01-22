<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_list_unsubscribe
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();

    $this->CI->load->model('model_list_unsubscribe');
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

  function store($email_id, $status = array())
  {
    // $status['campaign']     = isset($status['campaign']) ? $status['campaign'] : 1;
    // $status['tips']         = 1;
    // $status['newsletter']   = isset($status['newsletter']) ? $status['newsletter'] : 1;
    // $status['promotion']    = isset($status['promotion']) ? $status['promotion'] : 1;
    // $status['notification'] = isset($status['notification']) ? $status['notification'] : 1;
    // $status['announcement'] = isset($status['announcement']) ? $status['announcement'] : 1;
    // $status['digest']       = 1;

    // return $this->CI->model_email_status->store($email_id, $status);
  }

  function unsubscribe($email_id, $type)
  {
    // $this->CI->load->library('email/lib_send_email');

    // if ($this->CI->lib_send_email->can_unsubscribe($type))
    // {
    //   $status[ $type ] = 0;
    //   return $this->CI->model_email_status->store($email_id, $status);
    // }
  }

  function get($list_id)
  {
    return $this->CI->model_list_unsubscribe->get($list_id);
  }

  function get_list()
  {
    return $this->CI->model_list_unsubscribe->get_list();
  }

  function create($name)
  {
    if ( ! $this->CI->model_list_unsubscribe->is_available($name))
    {
      $this->error = ['message' => 'list: "'.$name.'" has already beed created, pick a different name'];
      return NULL;
    }

    return $this->CI->model_list_unsubscribe->create($name);
  }

  function modify($list_id, $name)
  {
    if ( ! $this->CI->model_list_unsubscribe->is_available($name, $list_id))
    {
      $this->error = ['message' => 'list: "'.$name.'" has already beed created, pick a different name'];
      return NULL;
    }

    $this->CI->model_list_unsubscribe->modify($list_id, $name);
    return TRUE;
  }

  function delete($list_id)
  {
    return $this->CI->model_list_unsubscribe->delete($list_id);
  }
}