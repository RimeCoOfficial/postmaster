<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_transaction extends CI_Model
{
  private $transaction_table = 'transaction';
  private $category_table = 'category';

  function get($transaction_id)
  {
    $this->db->limit(1);

    $this->db->where('transaction_id', $transaction_id);
    $query = $this->db->get($this->transaction_table);
    return $query->row_array();
  }

  function get_list()
  {
    $this->db->select($this->transaction_table.'.*');
    $this->db->select($this->category_table.'.name AS category_name');

    $this->db->order_by($this->transaction_table.'.category_id', 'ASC');

    $this->db->join($this->category_table, $this->transaction_table.'.category_id = '.$this->category_table.'.category_id');

    $query = $this->db->get($this->transaction_table);
    return $query->result_array();
  }

  function create($subject, $category_id)
  {
    $this->db->set('subject', $subject);
    $this->db->set('category_id', $category_id);

    $this->db->insert($this->transaction_table);
    return $this->db->insert_id();
  }

  function update($transaction_id, $subject, $reply_to_name, $reply_to_email, $body_html, $category_id)
  {
    $this->db->set('subject', $subject);
    $this->db->set('reply_to_name', $reply_to_name);
    $this->db->set('reply_to_email', $reply_to_email);
    $this->db->set('body_html', $body_html);
    $this->db->set('category_id', $category_id);

    $this->db->where('transaction_id', $transaction_id);

    $this->db->update($this->transaction_table);
  }
}