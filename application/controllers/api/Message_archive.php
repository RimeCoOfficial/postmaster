<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_archive extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->helper('api');
    
    $this->load->library('lib_api');
    if (is_null($this->lib_api->check_api_key())) output_error($this->lib_api->get_error_message());

    $this->load->library('lib_message_archive');
  }

  /*
# Request
curl -X POST -i http://localhost/postmaster/api/message-archive/get-info/[request_id]/[unsubscribe_key] -d \
"key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"

# Respoonse
HTTP/1.1 200 OK
Date: Wed, 03 Feb 2016 06:58:16 GMT
Server: Apache/2.4.16 (Unix) PHP/5.6.16
X-Powered-By: PHP/5.6.16
Content-Length: 172
Content-Type: application/json; charset=utf-8

{
    "list_recipient_id": "visitor-ecfa94f6c8ef80696ba6ee7d2434cbf7@suvozit.com",
    "list_id": "1",
    "to_name": "Shubhajit Saha",
    "to_email": "www@suvozit.com",
    "message_id": "1"
}
  */
  function get_info($request_id = NULL, $unsubscribe_key = NULL)
  {
    if (is_null($result = $this->lib_message_archive->get_info($request_id, $unsubscribe_key)))
    {
      output_error($this->lib_message_archive->get_error_message());
    }

    output($result);
  }
}