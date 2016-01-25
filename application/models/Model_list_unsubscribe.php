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

  function get_list()
  {
    $this->db->limit(50);

    $this->db->order_by('list_id', 'DESC');

    $query = $this->db->get($this->list_unsubscribe_table);
    return $query->result_array();
  }

  function is_available($list, $list_id = 0)
  {
    $this->db->where('list', $list);
    $this->db->where('list_id !=', $list_id);

    $query = $this->db->get($this->list_unsubscribe_table);
    return $query->num_rows() == 0;
  }

  function create($list, $reply_to_name, $reply_to_email)
  {
    $this->db->set('list', $list);
    
    $this->db->insert($this->list_unsubscribe_table);
    return $this->db->insert_id();
  }

  function update($list_id, $list, $reply_to_name, $reply_to_email)
  {
    $this->db->set('list', $list);

    $this->db->where('list_id', $list_id);

    $this->db->update($this->list_unsubscribe_table);
  }

  function delete($list_id)
  {
    $this->db->where('list_id', $list_id);
    $this->db->delete($this->list_unsubscribe_table);

    return $this->db->affected_rows() > 0;
  }
}