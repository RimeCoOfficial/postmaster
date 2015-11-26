<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_message_send extends CI_Model
{
  private $message_send_table = 'message_send';

  function store($message_list)
  {
    $this->db->insert_batch($this->message_send_table, $message_list);
  }
}