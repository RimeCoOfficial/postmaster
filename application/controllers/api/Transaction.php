<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->helper('api');
    
    $this->load->library('lib_api');
    if (is_null($this->lib_api->check_api_key())) output_error($this->lib_api->get_error_message());

    $this->load->library('lib_transaction');
  }

  public function send($message_id = 0)
  {
    if (is_null($result = $this->lib_transaction->add_message()))
    {
      output_error($this->lib_transaction->get_error_message());
    }

    output($result);
  }
}
