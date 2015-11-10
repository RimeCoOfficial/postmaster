<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_category extends CI_Model
{
  private $category_table = 'category';

  function get($category_id)
  {
    $this->db->limit(1);
    $this->db->where('category_id', $category_id);

    $query = $this->db->get($this->category_table);
    return $query->row_array();
  }

  function get_list()
  {
    $this->db->order_by('name', 'ASC');

    $query = $this->db->get($this->category_table);
    return $query->result_array();
  }

  function is_available($name, $category_id = 0)
  {
    $this->db->where('name', $name);
    $this->db->where('category_id !=', $category_id);

    $query = $this->db->get($this->category_table);
    return $query->num_rows() == 0;
  }

  function create($name, $reply_to_name, $reply_to_email)
  {
    $this->db->set('name', $name);
    
    $this->db->insert($this->category_table);
    return $this->db->insert_id();
  }

  function modify($category_id, $name, $reply_to_name, $reply_to_email)
  {
    $this->db->set('name', $name);

    $this->db->where('category_id', $category_id);

    $this->db->update($this->category_table);
  }
}