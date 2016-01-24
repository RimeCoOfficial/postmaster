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

    // $this->db->where($this->message_table.'.message_id', $message_id);

    $this->db->order_by($this->message_table.'.message_id', 'DESC');

    $this->db->join($this->list_unsubscribe_table, $this->list_unsubscribe_table.'.list_id = '.$this->message_table.'.list_id');

    $query = $this->db->get($this->message_table);
    return $query->result_array();
  }

  function create($subject, $owner, $list_id, $published)
  {
    $this->db->set('subject', $subject);
    $this->db->set('owner', $owner);
    $this->db->set('list_id', $list_id);
    $this->db->set('published', $published);

    $this->db->insert($this->message_table);
    return $this->db->insert_id();
  }

  function update($message_id, $subject, $owner, $list_id, $published, $body_html_input, $body_html, $body_text, $reply_to_name, $reply_to_email)
  {
    $this->db->set('subject', $subject);
    $this->db->set('owner', $owner);
    $this->db->set('list_id', $list_id);
    $this->db->set('reply_to_name', $reply_to_name);
    $this->db->set('reply_to_email', $reply_to_email);
    $this->db->set('body_html_input', $body_html_input);
    $this->db->set('body_html', $body_html);
    $this->db->set('body_text', $body_text);

    $this->db->set('published', $published);

    $this->db->where('message_id', $message_id);
    $this->db->where('archived', '1000-01-01 00:00:00');

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

  // function get_list()
  // {
  //   $this->db->limit(50);

  //   $this->db->select($this->message_table.'.*');
  //   $this->db->select($this->list_unsubscribe_table.'.list');

  //   $this->db->order_by($this->message_table.'.message_id', 'DESC');

  //   $this->db->join($this->message_table, $this->message_table.'.message_id = '.$this->transactional_table.'.message_id');
  //   $this->db->join($this->list_unsubscribe_table, $this->list_unsubscribe_table.'.list_id = '.$this->transactional_table.'.list_id', 'LEFT');

  //   // $this->db->where('published >', '1000-01-01 00:00:00');
    
  //   $query = $this->db->get($this->transactional_table);
  //   return $query->result_array();
  // }

  // function update($message_id, $list_id)
  // {
  //   $this->db->set('list_id', $list_id);

  //   $this->db->where('message_id', $message_id);

  //   $this->db->update($this->transactional_table);
  // }
}