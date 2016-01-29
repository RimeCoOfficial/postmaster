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

    $this->load->library('lib_list_unsubscribe');
  }

  /*
  curl -X POST -i http://postmaster.example.com/api/list-unsubscribe/subscribe/test -d \
  "key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
  &to_email=nemo@example.com\
  &subscribed=20YY-MM-DD HH:MM:SS"
  */
  public function subscribe($list = NULL)
  {
    if (is_null($result = $this->lib_list_unsubscribe->subscribe($list)))
    {
      output_error($this->lib_list_unsubscribe->get_error_message());
    }

    output($result);
  }

  /*
  curl -X POST -i http://postmaster.example.com/api/list-unsubscribe/unsubscribe/test -d \
  "key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
  &to_email=nemo@example.com\
  &unsubscribed=1000-00-00 00:00:00"
  */
  public function unsubscribe($list)
  {}

  /*
  curl -X POST -i http://postmaster.example.com/api/list-unsubscribe/update_metadata -d \
  "key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
  &to_name=nemo\
  &to_email=nemo@example.com\
  &custom_id=\
  &metadata[username]=nemo\
  &metadata[location]=IN\
  &updated=20YY-MM-DD HH:MM:SS"
  */
  public function update_metadata()
  {}

  // create
  // update
  // delete
}