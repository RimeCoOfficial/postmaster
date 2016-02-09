<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_message extends CI_Model
{
  private $message_table = 'message';
  private $list_unsubscribe_table = 'list_unsubscribe';

  function get($message_id)
  {
    $this->db->limit(1);

    $this->db->select($this->message_table.'.*');
    $this->db->select($this->list_unsubscribe_table.'.list');
    $this->db->select($this->list_unsubscribe_table.'.type');

    $this->db->where($this->message_table.'.message_id', $message_id);

    $this->db->order_by($this->message_table.'.message_id', 'DESC');

    $this->db->join($this->list_unsubscribe_table, $this->list_unsubscribe_table.'.list_id = '.$this->message_table.'.list_id');

    $query = $this->db->get($this->message_table);
    return $query->row_array();
  }

  function get_list()
  {
    $this->db->limit(50);
    
    $this->db->select($this->message_table.'.*');
    $this->db->select($this->list_unsubscribe_table.'.list');
    $this->db->select($this->list_unsubscribe_table.'.type');

    $this->db->order_by($this->message_table.'.message_id', 'DESC');

    $this->db->join($this->list_unsubscribe_table, $this->list_unsubscribe_table.'.list_id = '.$this->message_table.'.list_id');

    // $this->db->where('published_tds >', '1000-01-01 00:00:00');

    $query = $this->db->get($this->message_table);
    return $query->result_array();
  }

  function create($subject, $list_id)
  {
    $this->db->set('subject', $subject);
    $this->db->set('list_id', $list_id);

    $this->db->insert($this->message_table);
    return $this->db->insert_id();
  }

  function update($message_id, $subject, $body_html_input, $body_html, $body_text, $reply_to_name, $reply_to_email, $list_unsubscribe)
  {
    $this->db->set('subject', $subject);
    $this->db->set('reply_to_name', $reply_to_name);
    $this->db->set('reply_to_email', $reply_to_email);
    $this->db->set('body_html_input', $body_html_input);
    $this->db->set('body_html', $body_html);
    $this->db->set('body_text', $body_text);
    $this->db->set('list_unsubscribe', $list_unsubscribe);

    $this->db->where('message_id', $message_id);
    $this->db->where('archived', '1000-01-01 00:00:00');

    $this->db->update($this->message_table);
  }

  function update_publish($message_id, $published_tds)
  {
    $this->db->set('published_tds', $published_tds);

    $this->db->where('message_id', $message_id);
    $this->db->where('archived', '1000-01-01 00:00:00');

    $this->db->update($this->message_table);
  }

  function archive($message_id)
  {
    $this->db->set('archived', 'CURRENT_TIMESTAMP()', FALSE);
    
    $this->db->where('message_id', $message_id);
    $this->db->where('archived', '1000-01-01 00:00:00');

    $this->db->update($this->message_table);
  }

  function unarchive($message_id)
  {
    $this->db->set('archived', '1000-01-01 00:00:00');
    
    $this->db->where('message_id', $message_id);
    $this->db->where('archived !=', '1000-01-01 00:00:00');

    $this->db->update($this->message_table);
  }
}