<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactional extends CI_Controller
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
curl -X POST -i http://localhost/postmaster/api/transactional/send/1 -d \
"key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
&list_recipient_id=visitor-349c1e1bc65358a50d168f7d29ecd3e1@live.com\
&to_name=Shubhajit Saha\
&to_email=suvozit@live.com\
&pseudo_vars[foo]=bar"
  */
  public function send($message_id = 0)
  {
    if (is_null($result = $this->lib_message->add_request($message_id)))
    {
      output_error($this->lib_message->get_error_message());
    }

    output($result);
  }
}
