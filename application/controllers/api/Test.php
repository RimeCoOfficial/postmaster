<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{
  public function index()
  {
    $this->load->library('lib_send_email');
    $message_id = $this->lib_send_email->general(getenv('email_debug'), 'foo', 'bar');
    
    $response = array('status' => 'OK', 'email' => getenv('email_debug'), 'message_id' => $message_id);

    $this->output
      ->set_status_header(200)
      ->set_content_type('application/json', 'utf-8')
      ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
      ->_display();
      
    exit;
  }
}
