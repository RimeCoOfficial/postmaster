<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{
  public function index()
  {
    $this->load->library('lib_send_email');
    $message_id = $this->lib_send_email->general(getenv('email_debug'), 'foo', 'bar');
    
    $this->load->helper('api');
    $response = array('email' => getenv('email_debug'), 'message_id' => $message_id);
    output($response);
  }
}
