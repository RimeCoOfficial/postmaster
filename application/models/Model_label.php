<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_label extends CI_Model
{
  private $label_table = 'label';

  function get($label_id)
  {
    $this->db->limit(1);
    $this->db->where('label_id', $label_id);

    $query = $this->db->get($this->label_table);
    return $query->row_array();
  }

  function get_list()
  {
    $this->db->limit(50);

    $this->db->order_by('name', 'ASC');

    $query = $this->db->get($this->label_table);
    return $query->result_array();
  }

  function is_available($name, $label_id = 0)
  {
    $this->db->where('name', $name);
    $this->db->where('label_id !=', $label_id);

    $query = $this->db->get($this->label_table);
    return $query->num_rows() == 0;
  }

  function create($name, $reply_to_name, $reply_to_email)
  {
    $this->db->set('name', $name);
    
    $this->db->insert($this->label_table);
    return $this->db->insert_id();
  }

  function modify($label_id, $name, $reply_to_name, $reply_to_email)
  {
    $this->db->set('name', $name);

    $this->db->where('label_id', $label_id);

    $this->db->update($this->label_table);
  }

  function delete($label_id)
  {
    $this->db->where('label_id', $label_id);
    $this->db->delete($this->label_table);

    return $this->db->affected_rows() > 0;
  }
}