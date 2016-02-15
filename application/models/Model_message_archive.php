<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_message_archive extends CI_Model
{
  private $message_archive_table = 'message_archive';
  private $message_request_table = 'message_request';
  private $message_table = 'message';
  private $list_unsubscribe_table = 'list_unsubscribe';
  private $list_recipient_table = 'list_recipient';

  function store($message_list)
  {
    $this->db->insert_batch($this->message_archive_table, $message_list);
  }

  function get($request_id, $web_version_key)
  {
    $this->db->select($this->message_archive_table.'.*');
    
    $this->db->limit(1);

    $this->db->where('request_id', $request_id);
    $this->db->where('web_version_key', $web_version_key);

    $query = $this->db->get($this->message_archive_table);
    return $query->row_array();
  }

  function get_list($type, $count)
  {
    // $this->db->select($this->message_archive_table.'.*');
    $this->db->select($this->message_request_table.'.request_id');
    $this->db->select($this->message_archive_table.'.web_version_key');
    $this->db->select($this->message_archive_table.'.subject');
    $this->db->select($this->message_archive_table.'.sent');
    $this->db->select($this->message_request_table.'.to_name');
    $this->db->select($this->message_request_table.'.to_email');
    $this->db->select($this->message_request_table.'.created');
    $this->db->select($this->message_table.'.message_id');
    $this->db->select($this->message_table.'.list_id');
    $this->db->select($this->list_unsubscribe_table.'.type');
    $this->db->select($this->list_unsubscribe_table.'.list');

    $this->db->limit($count);
    $this->db->order_by($this->message_request_table.'.request_id', 'DESC');

    // $this->db->where('sent', '1000-01-01 00:00:00');

    $this->db->join($this->message_archive_table, $this->message_request_table.'.request_id = '.$this->message_archive_table.'.request_id', 'LEFT');
    $this->db->join($this->message_table, $this->message_table.'.message_id = '.$this->message_request_table.'.message_id');
    $this->db->join($this->list_unsubscribe_table, $this->list_unsubscribe_table.'.list_id = '.$this->message_table.'.list_id');

    if (!empty($type)) $this->db->where('type', $type);

    $query = $this->db->get($this->message_request_table);
    return $query->result_array();
  }

  function get_unsent($count)
  {
    $this->db->limit($count);
    
    $this->db->order_by('request_id', 'ASC');
    $this->db->order_by('priority', 'DESC');

    $this->db->where('sent', '1000-01-01 00:00:00');

    $query = $this->db->get($this->message_archive_table);
    return $query->result_array();
  }

  function mark_sent($message_list)
  {
    $this->db->update_batch($this->message_archive_table, $message_list, 'request_id');
  }

  function get_info($request_id, $unsubscribe_key)
  {
    $this->db->select($this->list_recipient_table.'.list_recipient_id');
    $this->db->select($this->list_recipient_table.'.list_id');
    $this->db->select($this->message_request_table.'.to_name');
    $this->db->select($this->message_request_table.'.to_email');
    $this->db->select($this->message_request_table.'.message_id');

    $this->db->limit(1);

    $this->db->join($this->message_request_table, $this->message_request_table.'.request_id = '.$this->message_archive_table.'.request_id');
    $this->db->join($this->list_recipient_table, $this->list_recipient_table.'.auto_recipient_id = '.$this->message_request_table.'.auto_recipient_id');

    $this->db->where($this->message_archive_table.'.request_id', $request_id);
    $this->db->where($this->message_archive_table.'.unsubscribe_key', $unsubscribe_key);

    $query = $this->db->get($this->message_archive_table);
    return $query->row_array();
  }

  function set_ses_message($ses_message_id, $to_email, $ses_feedback_json)
  {
    $this->db->where('ses_message_id', $ses_message_id);
    $this->db->where('to_email', $to_email);

    $this->db->set('ses_feedback_json', $ses_feedback_json);

    $this->db->update($this->message_archive_table);
    return $this->db->affected_rows() > 0;
  }
}