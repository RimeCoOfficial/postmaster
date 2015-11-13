<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_transaction extends CI_Model
{
  private $transaction_table = 'transaction';
  private $label_table = 'label';
  private $message_table = 'message';

  function get($message_id)
  {
    $this->db->limit(1);

    $this->db->where('message_id', $message_id);
    $query = $this->db->get($this->transaction_table);
    return $query->row_array();
  }

  function get_list()
  {
    $this->db->limit(50);

    $this->db->select($this->message_table.'.*');
    $this->db->select($this->transaction_table.'.*');
    $this->db->select($this->label_table.'.name AS label_name');

    $this->db->order_by($this->transaction_table.'.message_id', 'DESC');
    // $this->db->order_by($this->transaction_table.'.label_id', 'ASC');

    $this->db->join($this->message_table, $this->transaction_table.'.message_id = '.$this->message_table.'.message_id');
    $this->db->join($this->label_table, $this->transaction_table.'.label_id = '.$this->label_table.'.label_id', 'LEFT');

    $query = $this->db->get($this->transaction_table);
    return $query->result_array();
  }

  function get_available_message_list()
  {
    $this->db->limit(50);

    $this->db->select($this->message_table.'.*');

    $this->db->order_by($this->message_table.'.message_id', 'DESC');

    $this->db->join($this->transaction_table, $this->message_table.'.message_id = '.$this->transaction_table.'.message_id', 'LEFT');
    $this->db->where($this->transaction_table.'.message_id IS NULL');

    $query = $this->db->get($this->message_table);
    return $query->result_array();
  }

  function create($message_id, $label_id)
  {
    $this->db->set('message_id', $message_id);
    $this->db->set('label_id', $label_id);

    $this->db->insert($this->transaction_table);
  }

  function update($message_id, $label_id)
  {
    $this->db->set('label_id', $label_id);

    $this->db->where('message_id', $message_id);

    $this->db->update($this->transaction_table);
  }

  function delete($message_id)
  {
    $this->db->where('message_id', $message_id);
    $this->db->delete($this->transaction_table);

    return $this->db->affected_rows() > 0;
  }
}