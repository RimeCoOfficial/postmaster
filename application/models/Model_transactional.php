<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_transactional extends CI_Model
{
  private $transaction_category_table = 'transaction_category';
  private $transaction_table = 'transaction';

  function get_category_list()
  {
    $this->db->order_by('category', 'ASC');

    $query = $this->db->get($this->transaction_category_table);
    return $query->result_array();
  }

  function is_category_available($category)
  {
    $this->db->where('category', $category);

    $query = $this->db->get($this->transaction_category_table);
    return $query->num_rows() == 0;
  }

  function create_category($category, $reply_to_name, $reply_to_email)
  {
    $this->db->set('category', $category);
    $this->db->set('reply_to_name', $reply_to_name);
    $this->db->set('reply_to_email', $reply_to_email);

    $this->db->insert($this->transaction_category_table);
    return $this->db->insert_id();
  }
}