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
curl -X POST -i http://postmaster.example.com/api/message/transactional/1 -d \
"key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
&list_recipient_id=visitor-fd876f8cd6a58277fc664d47ea10ad19\
&to_name=John Doe\
&to_email=johndoe@example.com\
&pseudo_vars[foo]=bar"

curl -X POST -i http://localhost/postmaster/api/message/transactional/1 -d \
"key=ce1bb981e00cacca2d248261a0a4a530\
&list_recipient_id=visitor-fd876f8cd6a58277fc664d47ea10ad19\
&to_name=John Doe\
&to_email=johndoe@example.com\
&pseudo_vars[foo]=bar"
  */
  public function transactional($message_id = 0)
  {
    if (is_null($result = $this->lib_message->add_request($message_id)))
    {
      output_error($this->lib_message->get_error_message());
    }

    output($result);
  }
}
