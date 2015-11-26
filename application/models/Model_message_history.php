<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_message_history extends CI_Model
{
  private $message_table = 'message';
  private $message_history_table = 'message_history';

  function can_add($message_id, $owner)
  {
    $this->db->limit(1);

    $this->db->where('message_id', $message_id);

    if (!empty($owner)) $this->db->where('owner', $owner);

    $query = $this->db->get($this->message_table);
    return $query->num_rows() == 1;
  }

  function add($message_id, $to_name, $to_email, $subject, $body)
  {
    $this->db->set('message_id', $message_id);
    $this->db->set('to_name', $to_name);
    $this->db->set('to_email', $to_email);
    $this->db->set('subject', $subject);
    $this->db->set('body', $body);

    $this->db->insert($this->message_history_table);
    return $this->db->insert_id();
  }

  function get_to_process($count = 100)
  {
    $this->db->limit($count);
    $this->db->order_by('history_id', 'ASC');

    $this->db->join($this->message_table, $this->message_table.'.message_id = '.$this->message_history_table.'.message_id');

    $this->db->where('processed', '1000-01-01 00:00:00');

    $query = $this->db->get($this->message_history_table);
    return $query->result_array();
  }

  function mark_processed($message_list)
  {
    $this->db->update_batch($this->message_history_table, $message_list, 'history_id');
  }
}