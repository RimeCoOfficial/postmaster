<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_recipient extends CI_Model
{
  private $recipient_table = 'recipient';

  function get($list_id, $recipient_id)
  {
    $this->db->limit(1);
    $this->db->where('list_id', $list_id);
    $this->db->where('recipient_id', $recipient_id);

    $query = $this->db->get($this->recipient_table);
    return $query->row_array();
  }

  function get_list($list_id, $count)
  {
    $this->db->limit($count);

    $this->db->order_by('updated', 'DESC');

    $this->db->where('list_id', $list_id);

    $query = $this->db->get($this->recipient_table);
    return $query->result_array();
  }

  function create($list_id, $recipient_id, $to_name, $to_email)
  {
    $this->db->set('list_id', $list_id);
    $this->db->set('recipient_id', $recipient_id);
    $this->db->set('to_name', $to_name);
    $this->db->set('to_email', $to_email);

    $this->db->insert($this->recipient_table);
    return $this->db->insert_id();
  }

  function subscribe($auto_recipient_id, $subscribed)
  {
    $this->db->set('unsubscribed', '1000-01-01 00:00:00');

    $this->db->where('auto_recipient_id', $auto_recipient_id);
    $this->db->where('unsubscribed <', $subscribed);

    $this->db->update($this->recipient_table);
    return $this->db->affected_rows() > 0;
  }

  function unsubscribe($auto_recipient_id, $unsubscribed)
  {
    $this->db->set('unsubscribed', $unsubscribed);

    $this->db->where('auto_recipient_id', $auto_recipient_id);
    $this->db->where('unsubscribed <', $unsubscribed);

    $this->db->update($this->recipient_table);
    return $this->db->affected_rows() > 0;
  }

  function update_metadata($auto_recipient_id, $to_name, $to_email, $metadata_json, $metadata_updated, $update_recipient_id = FALSE)
  {
    $this->db->set('to_name', $to_name);
    $this->db->set('to_email', $to_email);
    $this->db->set('metadata_json', $metadata_json);

    if ($update_recipient_id)  $this->db->where('recipient_id', $update_recipient_id);
    else                       $this->db->where('auto_recipient_id', $auto_recipient_id);

    $this->db->where('metadata_updated <', $metadata_updated);

    $this->db->update($this->recipient_table);
    return $this->db->affected_rows() > 0;
  }

  function unsubscribe_all($recipient_id, $unsubscribed)
  {
    $this->db->set('unsubscribed', $unsubscribed);

    $this->db->where('recipient_id', $recipient_id);
    $this->db->where('unsubscribed <', $unsubscribed);

    $this->db->update($this->recipient_table);
    return $this->db->affected_rows() > 0;
  }

  function subscribe_all($recipient_id, $subscribed)
  {
    $this->db->set('unsubscribed', '1000-01-01 00:00:00');

    $this->db->where('recipient_id', $recipient_id);
    $this->db->where('unsubscribed <', $subscribed);

    $this->db->update($this->recipient_table);
    return $this->db->affected_rows() > 0;
  }
}