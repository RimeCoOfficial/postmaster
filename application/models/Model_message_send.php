<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_message_send extends CI_Model
{
  private $message_send_table = 'message_send';

  function store($message_list)
  {
    $this->db->insert_batch($this->message_send_table, $message_list);
  }

  function get_to_send($count)
  {
    $this->db->limit($count);
    $this->db->order_by('history_id', 'ASC');
    $this->db->order_by('priority', 'DESC');

    $this->db->where('email_sent', '1000-01-01 00:00:00');

    $query = $this->db->get($this->message_send_table);
    return $query->result_array();
  }

  function mark_sent($message_list)
  {
    $this->db->update_batch($this->message_send_table, $message_list, 'history_id');
  }
}