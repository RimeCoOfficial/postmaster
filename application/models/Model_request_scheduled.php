<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_request_scheduled extends CI_Model
{
    private $message_table = 'message';
    private $list_unsubscribe_table = 'list_unsubscribe';
    private $recipient_table = 'recipient';
    private $request_table = 'request';

    function get_autoresponder_recipients($count)
    {
        $this->db->limit($count);

        $this->db->select($this->message_table.'.message_id');
        $this->db->select($this->recipient_table.'.auto_recipient_id');
        $this->db->select($this->recipient_table.'.to_name');
        $this->db->select($this->recipient_table.'.to_email');
        $this->db->select($this->recipient_table.'.metadata_json');

        $this->db->join($this->message_table, $this->message_table.'.list_id = '.$this->recipient_table.'.list_id');
        $this->db->join($this->list_unsubscribe_table, $this->list_unsubscribe_table.'.list_id = '.$this->message_table.'.list_id');

        // multiple message in a list: match the auto_recipient_id and message_id
        $this->db->join($this->request_table, $this->request_table.'.auto_recipient_id = '.$this->recipient_table.'.auto_recipient_id AND '.$this->request_table.'.message_id = '.$this->message_table.'.message_id', 'LEFT');

        $this->db->where('TIMESTAMPDIFF(SECOND, '.$this->recipient_table.'.created, CURRENT_TIMESTAMP()) > '.$this->message_table.'.published_tds');

        $this->db->where($this->request_table.'.request_id IS NULL');
        $this->db->where($this->message_table.'.archived', '1000-01-01 00:00:00');
        $this->db->where($this->message_table.'.published_tds IS NOT NULL');
        // $this->db->where($this->message_table.'.published_tds >', 0); // not transactions // autoresponders can be 0
        $this->db->where($this->list_unsubscribe_table.'.type', 'autoresponder');

        $query = $this->db->get($this->recipient_table);
        return $query->result_array();
    }

    function get_latest_campaign()
    {
        $this->db->limit(1);

        $this->db->select($this->message_table.'.message_id');
        $this->db->select($this->message_table.'.list_id');
        $this->db->select($this->message_table.'.created');
        $this->db->select($this->message_table.'.body_html');
        $this->db->select($this->message_table.'.body_text');
        $this->db->select($this->list_unsubscribe_table.'.list');
        $this->db->select($this->list_unsubscribe_table.'.type');

        $this->db->join($this->list_unsubscribe_table, $this->list_unsubscribe_table.'.list_id = '.$this->message_table.'.list_id');

        $this->db->where('TIMESTAMPDIFF(SECOND, \'1000-01-01 00:00:00\', CURRENT_TIMESTAMP()) > '.$this->message_table.'.published_tds');

        $this->db->where($this->message_table.'.archived', '1000-01-01 00:00:00');
        $this->db->where($this->message_table.'.published_tds IS NOT NULL');

        $this->db->where($this->list_unsubscribe_table.'.type', 'campaign');

        $query = $this->db->get($this->message_table);
        return $query->row_array();
    }

    function get_campaign_recipients($message_id, $list_id, $count)
    {
        $this->db->limit($count);

        $this->db->select($this->recipient_table.'.auto_recipient_id');
        $this->db->select($this->recipient_table.'.to_name');
        $this->db->select($this->recipient_table.'.to_email');
        $this->db->select($this->recipient_table.'.metadata_json');

        // multiple message in a list: match the auto_recipient_id and message_id
        $this->db->join($this->request_table, $this->request_table.'.auto_recipient_id = '.$this->recipient_table.'.auto_recipient_id AND '.$this->request_table.'.message_id = '.$message_id, 'LEFT');

        $this->db->where($this->request_table.'.request_id IS NULL');
        $this->db->where($this->recipient_table.'.list_id', $list_id);

        $query = $this->db->get($this->recipient_table);
        return $query->result_array();
    }
}
