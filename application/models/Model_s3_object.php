<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_s3_object extends CI_Model
{
  private $s3_object_table = 's3_object';

  function store($s3_key, $file_type, $file_size, $is_image)
  {
    $this->db->set('s3_key', $s3_key);
    $this->db->set('file_type', $file_type);
    $this->db->set('file_size', $file_size);
    $this->db->set('is_image', $is_image);

    $this->db->insert($this->s3_object_table);
  }

  function get_list()
  {
    $this->db->limit(50);

    $this->db->order_by('created', 'DESC');

    $query = $this->db->get($this->s3_object_table);
    return $query->result_array();
  }

  function delete($s3_key)
  {
    $this->db->where('s3_key', $s3_key);
    $this->db->delete($this->s3_object_table);
  }
}