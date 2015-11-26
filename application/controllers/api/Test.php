<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->helper('api');

    $this->load->library('lib_api');
    if (is_null($this->lib_api->check_api_key())) output_error($this->lib_api->get_error_message());
  }

  public function index()
  {
    $this->load->library('lib_send_email');
    $message_id = $this->lib_send_email->general(getenv('email_debug'), 'foo', 'bar');
    
    $this->load->helper('api');
    $response = array('email' => getenv('email_debug'), 'message_id' => $message_id);
    output($response);
  }
}
