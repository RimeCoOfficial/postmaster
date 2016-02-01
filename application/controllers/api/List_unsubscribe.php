<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_unsubscribe extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->helper('api');
    
    $this->load->library('lib_api');
    if (is_null($this->lib_api->check_api_key())) output_error($this->lib_api->get_error_message());

    $this->load->library('lib_list_recipient');
  }

  /*
curl -X POST -i http://localhost/postmaster/api/list-unsubscribe/subscribe/1 -d \
"key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
&list_recipient_id=visitor-349c1e1bc65358a50d168f7d29ecd3e1\
&to_name=Shubhajit Saha\
&to_email=suvozit@live.com\
&subscribed=2016-02-01 08:17:20"
  */
  public function subscribe($list_id = NULL)
  {
    if (is_null($result = $this->lib_list_recipient->subscribe($list_id)))
    {
      output_error($this->lib_list_recipient->get_error_message());
    }

    output($result);
  }

  /*
curl -X POST -i http://localhost/postmaster/api/list-unsubscribe/unsubscribe/1 -d \
"key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
&list_recipient_id=visitor-349c1e1bc65358a50d168f7d29ecd3e1\
&to_name=Shubhajit Saha\
&to_email=suvozit@live.com\
&unsubscribed=2016-02-01 08:17:20"
  */
  public function unsubscribe($list_id)
  {
    if (is_null($result = $this->lib_list_recipient->unsubscribe($list_id)))
    {
      output_error($this->lib_list_recipient->get_error_message());
    }

    output($result);
  }

  /*
curl -X POST -i http://postmaster.example.com/api/list-unsubscribe/metadata -d \
"key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
&list_recipient_id=visitor-349c1e1bc65358a50d168f7d29ecd3e1\
&to_name=Shubhajit Saha\
&to_email=suvozit@live.com\
&metadata[username]=nemo\
&metadata[location]=IN\
&updated=20YY-MM-DD HH:MM:SS"
  */
  public function metadata($list_id = NULL)
  {}

  // create
  // update
  // delete
}