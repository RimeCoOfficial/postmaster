<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_list_unsubscribe extends CI_Model
{
  private $list_unsubscribe_table = 'list_unsubscribe';

  function stats_unsubscribe()
  {
    // $this->db->select('sum(case when type = \'first\' then 1 else 0 end) as type_first');
    $this->db->select('sum(case when campaign = 0 then 1 else 0 end) as campaign');
    $this->db->select('sum(case when newsletter = 0 then 1 else 0 end) as newsletter');
    $this->db->select('sum(case when notification = 0 then 1 else 0 end) as notification');
    $this->db->select('sum(case when announcement = 0 then 1 else 0 end) as announcement');
    $this->db->select('sum(case when digest = 0 then 1 else 0 end) as digest');

    $query = $this->db->get($this->list_unsubscribe_table);
    return $query->row_array();
  }

  function get($list_id)
  {
    $this->db->limit(1);
    $this->db->where('list_id', $list_id);

    $query = $this->db->get($this->list_unsubscribe_table);
    return $query->row_array();
  }

  function get_by_name($list)
  {
    $this->db->limit(1);
    $this->db->where('LOWER(list)', strtolower($list));

    $query = $this->db->get($this->list_unsubscribe_table);
    return $query->row_array();
  }

  function get_list()
  {
    $this->db->limit(50);

    $this->db->order_by('list_id', 'DESC');

    $query = $this->db->get($this->list_unsubscribe_table);
    return $query->result_array();
  }

  function is_list_available($list)
  {
    $this->db->where('LOWER(list)', strtolower($list));
    
    $query = $this->db->get($this->list_unsubscribe_table);
    return $query->num_rows() == 0;
  }

  function create($list, $type)
  {
    $this->db->set('list', $list);
    $this->db->set('type', $type);
    
    $this->db->insert($this->list_unsubscribe_table);
    return $this->db->insert_id();
  }

  function update($list_id, $list)
  {
    $this->db->set('list', $list);

    $this->db->where('list_id', $list_id);

    $this->db->update($this->list_unsubscribe_table);
  }

  // function archive($list_id)
  // {
  //   $this->db->set('archived', 'CURRENT_TIMESTAMP()', FALSE);
    
  //   $this->db->where('list_id', $list_id);
  //   $this->db->where('archived', '1000-01-01 00:00:00');

  //   $this->db->update($this->list_unsubscribe_table);
  // }
}