<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller
{
  public function send($message_id = 0)
  {
    $this->load->helper('api');

    $this->load->library('lib_api');
    if (is_null($this->lib_api->check_api_key())) output_error($this->lib_api->get_error_message());

    $data = $this->input->post('data');

    output($data);
  }
}