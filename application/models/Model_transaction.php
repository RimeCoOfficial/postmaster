<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_transaction extends CI_Model
{
  private $transaction_table = 'transaction';

  function get($transaction_id)
  {
    $this->db->limit(1);

    $this->db->where('transaction_id', $transaction_id);
    $query = $this->db->get($this->transaction_table);
    return $query->row_array();
  }

  function get_list()
  {
    $this->db->order_by('category_id', 'ASC');

    $query = $this->db->get($this->transaction_table);
    return $query->result_array();
  }

  function create($subject)
  {
    $this->db->set('subject', $subject);

    $this->db->insert($this->transaction_table);
    return $this->db->insert_id();
  }

  function update($transaction_id, $subject, $reply_to_name, $reply_to_email)
  {
    $this->db->set('subject', $subject);
    $this->db->set('reply_to_name', $reply_to_name);
    $this->db->set('reply_to_email', $reply_to_email);

    $this->db->where('transaction_id', $transaction_id);

    $this->db->update($this->transaction_table);
  }
}