<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_message_send extends CI_Model
{
  private $message_send_table = 'message_send';
  private $message_request_table = 'message_request';
  private $message_table = 'message';

  function store($message_list)
  {
    $this->db->insert_batch($this->message_send_table, $message_list);
  }

  function get($request_id, $verify_id)
  {
    $this->db->select($this->message_send_table.'.*');
    
    $this->db->limit(1);

    $this->db->where('request_id', $request_id);
    $this->db->where('verify_id', $verify_id);

    $query = $this->db->get($this->message_send_table);
    return $query->row_array();
  }

  function get_list($owner, $count)
  {
    // $this->db->select($this->message_send_table.'.*');
    $this->db->select($this->message_request_table.'.request_id');
    $this->db->select($this->message_send_table.'.verify_id');
    $this->db->select($this->message_send_table.'.subject');
    $this->db->select($this->message_send_table.'.sent');
    $this->db->select($this->message_request_table.'.to_name');
    $this->db->select($this->message_request_table.'.to_email');
    $this->db->select($this->message_request_table.'.created');
    $this->db->select($this->message_table.'.message_id');
    $this->db->select($this->message_table.'.owner');

    $this->db->limit($count);
    $this->db->order_by($this->message_request_table.'.request_id', 'DESC');

    // $this->db->where('sent', '1000-01-01 00:00:00');

    $this->db->join($this->message_send_table, $this->message_request_table.'.request_id = '.$this->message_send_table.'.request_id', 'LEFT');
    $this->db->join($this->message_table, $this->message_table.'.message_id = '.$this->message_request_table.'.message_id');

    $this->db->where('owner', $owner);

    $query = $this->db->get($this->message_request_table);
    return $query->result_array();
  }

  function get_to_send($count)
  {
    $this->db->limit($count);
    $this->db->order_by('request_id', 'ASC');
    $this->db->order_by('priority', 'DESC');

    $this->db->where('sent', '1000-01-01 00:00:00');

    $query = $this->db->get($this->message_send_table);
    return $query->result_array();
  }

  function mark_sent($message_list)
  {
    $this->db->update_batch($this->message_send_table, $message_list, 'request_id');
  }
}