<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_status extends CI_Model
{
  private $status_table = 'status';

  function store($email_id, $status = array())
  {
    $status['email_id'] = $email_id;
    $this->db->insert_on_duplicate_update($this->status_table, $status);

    return $this->db->affected_rows() > 0;
  }

  function update_status($email_id, $status)
  {
    $this->db->where('email_id', $email_id);
    $this->db->where('status_timestamp <', $status['status_timestamp']);

    $this->db->update($this->status_table, $status);
    return $this->db->affected_rows() > 0;
  }

  function get($email_id)
  {
    $this->db->limit(1);
    $this->db->where('LOWER(email_id)=', strtolower($email_id));

    $query = $this->db->get($this->status_table);
    return $query->row_array();
  }

  function stats()
  {
    // SELECT status, COUNT(*) FROM status GROUP BY status;

    $this->db->select('email_id, status, status_type, status_timestamp, COUNT(*) AS count');
    $this->db->group_by('status');

    $query = $this->db->get($this->status_table);
    return $query->result_array();
  }

  function stats_unsubscribe()
  {
    // $this->db->select('sum(case when type = \'first\' then 1 else 0 end) as type_first');
    $this->db->select('sum(case when campaign = 0 then 1 else 0 end) as campaign');
    $this->db->select('sum(case when newsletter = 0 then 1 else 0 end) as newsletter');
    $this->db->select('sum(case when notification = 0 then 1 else 0 end) as notification');
    $this->db->select('sum(case when announcement = 0 then 1 else 0 end) as announcement');
    $this->db->select('sum(case when digest = 0 then 1 else 0 end) as digest');

    $query = $this->db->get($this->status_table);
    return $query->row_array();
  }
}