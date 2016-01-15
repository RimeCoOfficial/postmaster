<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_campaign extends CI_Model
{
  private $campaign_table = 'campaign';
  private $list_table = 'list';
  private $message_table = 'message';
  
  function create($message_id)
  {
    $this->db->set('message_id', $message_id);
    $this->db->insert($this->transactional_table);
  }

  function get_latest()
  {
    $this->db->limit(1);
    $this->db->where('sent_at', '1000-01-01 00:00:00');

    $query = $this->db->get($this->campaign_table);
    return $query->row_array();
  }

  function get_latest_to_send()
  {
    $this->db->limit(1);
    $this->db->order_by('news_id', 'ASC');

    $this->db->where('status IS NOT NULL');
    $this->db->where('sent_at < ', 'CURRENT_TIMESTAMP()', FALSE);

    $query = $this->db->get($this->campaign_table);
    return $query->row_array();
  }

  function get_by_id($news_id)
  {
    $this->db->limit(1);
    $this->db->where('news_id', $news_id);

    $query = $this->db->get($this->campaign_table);
    return $query->row_array();
  }

  function update($news_id, $description, $title, $html, $txt)
  {
    $this->db->set('title', $title);
    $this->db->set('description', $description);
    $this->db->set('html', $html);
    $this->db->set('txt', $txt);

    $this->db->where('news_id', $news_id);
    $this->db->where('sent_at', '1000-01-01 00:00:00');

    $this->db->update($this->campaign_table);
    return $this->db->affected_rows();
  }

  function update_sent_at($news_id, $sent_at)
  {
    $this->db->set('status', 'scheduled');
    // $this->db->set('sent_at', 'CURRENT_TIMESTAMP()', FALSE);
    $this->db->set('sent_at', $sent_at);

    $this->db->where('news_id', $news_id);
    $this->db->where('sent_at', '1000-01-01 00:00:00');
    // $this->db->where('\''.$sent_at.'\' > ', 'CURRENT_TIMESTAMP()', FALSE);

    $this->db->update($this->campaign_table);
    return $this->db->affected_rows();
  }

  function update_status($news_id, $status)
  {
    $this->db->set('status', $status);
    $this->db->where('news_id', $news_id);

    $this->db->update($this->campaign_table);
    return $this->db->affected_rows();
  }

  function get_archive($count = 1)
  {
    $this->db->limit($count);
    $this->db->order_by('news_id', 'DESC');

    $this->db->select('news_id, title, sent_at, status, created');
    $this->db->where('sent_at != ', '1000-01-01 00:00:00');

    $query = $this->db->get($this->campaign_table);
    return $query->result_array();
  }
}