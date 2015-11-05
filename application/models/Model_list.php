<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_list extends CI_Model
{
  private $list_table = 'list';

  function stats_unsubscribe()
  {
    // $this->db->select('sum(case when type = \'first\' then 1 else 0 end) as type_first');
    $this->db->select('sum(case when campaign = 0 then 1 else 0 end) as campaign');
    $this->db->select('sum(case when newsletter = 0 then 1 else 0 end) as newsletter');
    $this->db->select('sum(case when notification = 0 then 1 else 0 end) as notification');
    $this->db->select('sum(case when announcement = 0 then 1 else 0 end) as announcement');
    $this->db->select('sum(case when digest = 0 then 1 else 0 end) as digest');

    $query = $this->db->get($this->list_table);
    return $query->row_array();
  }
}