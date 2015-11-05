<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_feedback extends CI_Model
{
  private $feedback_table = 'feedback';

  function store($email_id, $feedback = array())
  {
    $feedback['email_id'] = $email_id;
    $this->db->insert_on_duplicate_update($this->feedback_table, $feedback);

    return $this->db->affected_rows() > 0;
  }

  function update($email_id, $feedback)
  {
    $this->db->where('email_id', $email_id);
    $this->db->where('timestamp <', $feedback['timestamp']);

    $this->db->update($this->feedback_table, $feedback);
    return $this->db->affected_rows() > 0;
  }

  function get($email_id)
  {
    $this->db->limit(1);
    $this->db->where('email_id', $email_id);

    $query = $this->db->get($this->feedback_table);
    return $query->row_array();
  }

  function stats()
  {
    // SELECT state, COUNT(*) FROM feedback GROUP BY state;

    $this->db->select('email_id, state, type, timestamp, COUNT(*) AS count');
    $this->db->group_by('state');

    $query = $this->db->get($this->feedback_table);
    return $query->result_array();
  }
}