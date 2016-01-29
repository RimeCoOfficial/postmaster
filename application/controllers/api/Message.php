<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->helper('api');
    
    $this->load->library('lib_api');
    if (is_null($this->lib_api->check_api_key())) output_error($this->lib_api->get_error_message());

    $this->load->library('lib_message');
  }

  /*
  curl -X POST -i http://postmaster.example.com/api/message/request-transactional -d \
  "key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
  &message_id=1\
  &list_recipent_id=\
  &email_id=nemo@example.com\
  &pseudo_vars[foo]=bar"
  */
  public function request_transactional($message_id = 0)
  {
    if (is_null($result = $this->lib_message->add_request()))
    {
      output_error($this->lib_message->get_error_message());
    }

    output($result);
  }
}
