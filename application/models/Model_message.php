<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_message extends CI_Model
{
  private $message_table = 'message';

  function get($message_id)
  {
    $this->db->limit(1);

    $this->db->where('message_id', $message_id);

    $query = $this->db->get($this->message_table);
    return $query->row_array();
  }

  function get_list()
  {
    $this->db->limit(50);
    
    $this->db->order_by($this->message_table.'.message_id', 'ASC');

    $query = $this->db->get($this->message_table);
    return $query->result_array();
  }

  function create($subject)
  {
    $this->db->set('subject', $subject);

    $this->db->insert($this->message_table);
    return $this->db->insert_id();
  }

  function update($message_id, $subject, $reply_to_name, $reply_to_email, $message_html)
  {
    $this->db->set('subject', $subject);
    $this->db->set('reply_to_name', $reply_to_name);
    $this->db->set('reply_to_email', $reply_to_email);
    $this->db->set('message_html', $message_html);

    $this->db->where('message_id', $message_id);

    $this->db->update($this->message_table);
  }
}