<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_message_request extends CI_Model
{
  private $message_table = 'message';
  private $list_unsubscribe_table = 'list_unsubscribe';
  private $list_recipient_table = 'list_recipient';
  private $message_request_table = 'message_request';

  function can_add($message_id)
  {
    $this->db->limit(1);

    $this->db->where('message_id', $message_id);
    $this->db->where('published_tds IS NOT NULL');
    $this->db->where('archived', '1000-01-01 00:00:00');

    $query = $this->db->get($this->message_table);
    return $query->num_rows() > 0;
  }

  function add($message_id, $auto_recipient_id, $to_name, $to_email, $pseudo_vars_json)
  {
    $this->db->set('message_id', $message_id);
    $this->db->set('auto_recipient_id', $auto_recipient_id);
    $this->db->set('to_name', $to_name);
    $this->db->set('to_email', $to_email);
    $this->db->set('pseudo_vars_json', $pseudo_vars_json);

    $this->db->insert($this->message_request_table);
    return $this->db->insert_id();
  }

  function add_batch($request_list)
  {
    $this->db->insert_batch($this->message_request_table, $request_list);
  }

  function get_to_process($count)
  {
    $this->db->limit($count);
    $this->db->order_by('request_id', 'ASC');

    $this->db->select($this->message_table.'.*');
    $this->db->select($this->message_request_table.'.*');
    $this->db->select($this->list_unsubscribe_table.'.list');
    $this->db->select($this->list_unsubscribe_table.'.type');
    $this->db->select($this->list_recipient_table.'.list_recipient_id');
    $this->db->select($this->list_recipient_table.'.to_name AS list_recipient_to_name');
    $this->db->select($this->list_recipient_table.'.unsubscribed');
    $this->db->select($this->list_recipient_table.'.metadata_json');

    $this->db->join($this->message_table, $this->message_table.'.message_id = '.$this->message_request_table.'.message_id');
    $this->db->join($this->list_unsubscribe_table, $this->list_unsubscribe_table.'.list_id = '.$this->message_table.'.list_id');
    $this->db->join($this->list_recipient_table, $this->list_recipient_table.'.auto_recipient_id = '.$this->message_request_table.'.auto_recipient_id');

    $this->db->where('processed', '1000-01-01 00:00:00');

    $query = $this->db->get($this->message_request_table);
    return $query->result_array();
  }

  function mark_processed($message_list)
  {
    $this->db->update_batch($this->message_request_table, $message_list, 'request_id');
  }
}