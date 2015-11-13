<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_transaction extends CI_Model
{
  private $transaction_table = 'transaction';
  private $label_table = 'label';
  private $message_table = 'message';

  function get($transaction_id)
  {
    $this->db->limit(1);

    $this->db->where('transaction_id', $transaction_id);
    $query = $this->db->get($this->transaction_table);
    return $query->row_array();
  }

  function get_list()
  {
    $this->db->select($this->message_table.'.*');
    $this->db->select($this->transaction_table.'.*');
    $this->db->select($this->label_table.'.name AS label_name');

    $this->db->order_by($this->transaction_table.'.label_id', 'ASC');

    $this->db->join($this->message_table, $this->transaction_table.'.transaction_id = '.$this->message_table.'.message_id');
    $this->db->join($this->label_table, $this->transaction_table.'.label_id = '.$this->label_table.'.label_id', 'LEFT');

    $query = $this->db->get($this->transaction_table);
    return $query->result_array();
  }

  function create($transaction_id, $label_id)
  {
    $this->db->set('transaction_id', $transaction_id);
    $this->db->set('label_id', $label_id);

    $this->db->insert($this->transaction_table);
  }

  function update($transaction_id, $label_id)
  {
    $this->db->set('label_id', $label_id);

    $this->db->where('transaction_id', $transaction_id);

    $this->db->update($this->transaction_table);
  }
}