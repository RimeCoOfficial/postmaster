<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_list_recipient extends CI_Model
{
  private $list_recipient_table = 'list_recipient';

  function get($list_id, $list_recipient_id)
  {
    $this->db->limit(1);
    $this->db->where('list_id', $list_id);
    $this->db->where('list_recipient_id', $list_recipient_id);

    $query = $this->db->get($this->list_recipient_table);
    return $query->row_array();
  }

  function create($list_id, $list_recipient_id, $to_name, $to_email)
  {
    $this->db->set('list_id', $list_id);
    $this->db->set('list_recipient_id', $list_recipient_id);
    $this->db->set('to_name', $to_name);
    $this->db->set('to_email', $to_email);

    $this->db->insert($this->list_recipient_table);
    return $this->db->insert_id();
  }

  function subscribe($auto_recipient_id, $subscribed)
  {
    $this->db->set('subscribed', $subscribed);

    $this->db->where('auto_recipient_id', $auto_recipient_id);
    $this->db->where('subscribed <', $subscribed);

    $this->db->update($this->list_recipient_table);
    return $this->db->affected_rows() > 0;
  }

  function unsubscribe($auto_recipient_id, $unsubscribed)
  {
    $this->db->set('unsubscribed', $unsubscribed);

    $this->db->where('auto_recipient_id', $auto_recipient_id);
    $this->db->where('unsubscribed <', $unsubscribed);

    $this->db->update($this->list_recipient_table);
    return $this->db->affected_rows() > 0;
  }

  function update_metadata($auto_recipient_id, $metadata_json, $metadata_updated)
  {
    $this->db->set('metadata_json', $metadata_json);

    $this->db->where('auto_recipient_id', $auto_recipient_id);
    $this->db->where('metadata_updated <', $metadata_updated);

    $this->db->update($this->list_recipient_table);
    return $this->db->affected_rows() > 0;
  }
}