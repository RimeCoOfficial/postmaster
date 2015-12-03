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
    
    $this->db->order_by($this->message_table.'.message_id', 'DESC');

    $query = $this->db->get($this->message_table);
    return $query->result_array();
  }

  function create($owner, $subject, $published)
  {
    $this->db->set('owner', $owner);
    $this->db->set('subject', $subject);
    $this->db->set('published', $published);

    $this->db->insert($this->message_table);
    return $this->db->insert_id();
  }

  function update($message_id, $owner, $subject, $published, $body_html_input, $reply_to_name, $reply_to_email)
  {
    $this->db->set('subject', $subject);
    $this->db->set('reply_to_name', $reply_to_name);
    $this->db->set('reply_to_email', $reply_to_email);
    $this->db->set('body_html_input', $body_html_input);
    $this->db->set('body_html', NULL);

    $this->db->set('published', $published);

    $this->db->where('message_id', $message_id);
    $this->db->where('owner', $owner);
    $this->db->where('archived', '1000-01-01 00:00:00');

    $this->db->update($this->message_table);
  }

  function update_html($message_id, $body_html_input, $body_html)
  {
    $this->db->set('body_html_input', $body_html_input);
    $this->db->set('body_html', $body_html);

    $this->db->where('message_id', $message_id);
    
    $this->db->update($this->message_table);
  }

  function archive($message_id, $owner)
  {
    $this->db->set('archived', 'CURRENT_TIMESTAMP()', FALSE);
    
    $this->db->where('message_id', $message_id);
    $this->db->where('owner', $owner);
    $this->db->where('archived', '1000-01-01 00:00:00');

    $this->db->update($this->message_table);
  }

  function unarchive($message_id, $owner)
  {
    $this->db->set('archived', '1000-01-01 00:00:00');
    
    $this->db->where('message_id', $message_id);
    $this->db->where('owner', $owner);
    $this->db->where('archived !=', '1000-01-01 00:00:00');

    $this->db->update($this->message_table);
  }
}