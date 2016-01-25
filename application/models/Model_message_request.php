<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_message_request extends CI_Model
{
  private $message_table = 'message';
  private $message_request_table = 'message_request';

  function can_add($message_id, $type)
  {
    $this->db->limit(1);

    $this->db->where('message_id', $message_id);

    if (!empty($type)) $this->db->where('type', $type);

    $this->db->where('published !=', '1000-01-01 00:00:00');
    $this->db->where('archived', '1000-01-01 00:00:00');

    $query = $this->db->get($this->message_table);
    return $query->num_rows() == 1;
  }

  function add($message_id, $to_name, $to_email, $pseudo_vars_json)
  {
    $this->db->set('message_id', $message_id);
    $this->db->set('to_name', $to_name);
    $this->db->set('to_email', $to_email);
    $this->db->set('pseudo_vars_json', $pseudo_vars_json);

    $this->db->insert($this->message_request_table);
    return $this->db->insert_id();
  }

  function get_to_process($count)
  {
    $this->db->limit($count);
    $this->db->order_by('request_id', 'ASC');

    $this->db->join($this->message_table, $this->message_table.'.message_id = '.$this->message_request_table.'.message_id');

    $this->db->where('processed', '1000-01-01 00:00:00');

    $query = $this->db->get($this->message_request_table);
    return $query->result_array();
  }

  function mark_processed($message_list)
  {
    $this->db->update_batch($this->message_request_table, $message_list, 'request_id');
  }
}