<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_archive extends CI_Model
{
  private $archive_table = 'archive';
  private $request_table = 'request';
  private $message_table = 'message';
  private $list_unsubscribe_table = 'list_unsubscribe';
  private $recipient_table = 'recipient';

  function store($message_list)
  {
    $this->db->insert_batch($this->archive_table, $message_list);
  }

  function get($request_id, $web_version_key)
  {
    $this->db->select($this->archive_table.'.*');
    
    $this->db->limit(1);

    $this->db->where('request_id', $request_id);
    $this->db->where('web_version_key', $web_version_key);

    $query = $this->db->get($this->archive_table);
    return $query->row_array();
  }

  function get_list($type, $count)
  {
    // $this->db->select($this->archive_table.'.*');
    $this->db->select($this->request_table.'.request_id');
    $this->db->select($this->archive_table.'.web_version_key');
    $this->db->select($this->archive_table.'.subject');
    $this->db->select($this->archive_table.'.sent');
    $this->db->select($this->archive_table.'.ses_feedback_json');
    $this->db->select($this->request_table.'.to_name');
    $this->db->select($this->request_table.'.to_email');
    $this->db->select($this->request_table.'.created');
    $this->db->select($this->request_table.'.processed');
    $this->db->select($this->request_table.'.processed_error');
    $this->db->select($this->message_table.'.message_id');
    $this->db->select($this->message_table.'.list_id');
    $this->db->select($this->list_unsubscribe_table.'.type');
    $this->db->select($this->list_unsubscribe_table.'.list');

    $this->db->limit($count);
    $this->db->order_by($this->request_table.'.request_id', 'DESC');

    // $this->db->where('sent', '1000-01-01 00:00:00');

    $this->db->join($this->archive_table, $this->request_table.'.request_id = '.$this->archive_table.'.request_id', 'LEFT');
    $this->db->join($this->message_table, $this->message_table.'.message_id = '.$this->request_table.'.message_id');
    $this->db->join($this->list_unsubscribe_table, $this->list_unsubscribe_table.'.list_id = '.$this->message_table.'.list_id');

    if (!empty($type)) $this->db->where('type', $type);

    $query = $this->db->get($this->request_table);
    return $query->result_array();
  }

  function get_unsent($count)
  {
    $this->db->limit($count);
    
    $this->db->order_by('request_id', 'ASC');
    $this->db->order_by('priority', 'DESC');

    $this->db->where('sent', '1000-01-01 00:00:00');

    $query = $this->db->get($this->archive_table);
    return $query->result_array();
  }

  function update_batch($message_list)
  {
    $this->db->update_batch($this->archive_table, $message_list, 'request_id');
  }

  function get_info($request_id, $unsubscribe_key)
  {
    $this->db->select($this->recipient_table.'.recipient_id');
    $this->db->select($this->recipient_table.'.list_id');
    $this->db->select($this->request_table.'.to_name');
    $this->db->select($this->request_table.'.to_email');
    $this->db->select($this->request_table.'.message_id');

    $this->db->limit(1);

    $this->db->join($this->request_table, $this->request_table.'.request_id = '.$this->archive_table.'.request_id');
    $this->db->join($this->recipient_table, $this->recipient_table.'.auto_recipient_id = '.$this->request_table.'.auto_recipient_id');

    $this->db->where($this->archive_table.'.request_id', $request_id);
    $this->db->where($this->archive_table.'.unsubscribe_key', $unsubscribe_key);

    $query = $this->db->get($this->archive_table);
    return $query->row_array();
  }

  function set_ses_message($ses_message_id, $to_email, $ses_feedback_json)
  {
    $this->db->where('ses_message_id', $ses_message_id);
    $this->db->where('to_email', $to_email);

    $this->db->set('ses_feedback_json', $ses_feedback_json);

    $this->db->update($this->archive_table);
    return $this->db->affected_rows() > 0;
  }

  function get_unarchive($count)
  {
    $this->db->limit($count);
    
    $this->db->order_by('request_id', 'ASC');

    $this->db->where('sent >', '1000-01-01 00:00:00');
    $this->db->where('archived', '1000-01-01 00:00:00');

    $query = $this->db->get($this->archive_table);
    return $query->result_array();
  }
}