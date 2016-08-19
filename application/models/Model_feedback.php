<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_feedback extends CI_Model
{
    private $feedback_table = 'feedback';

    function store($to_email)
    {
        $feedback['to_email'] = $to_email;
        $this->db->insert_on_duplicate_update($this->feedback_table, $feedback);

        return $this->db->affected_rows() > 0;
    }

    function update($feedback)
    {
        $this->db->where('to_email', $feedback['to_email']);

        // update latest
        $this->db->where('recieved <', $feedback['recieved']);

        $this->db->update($this->feedback_table, $feedback);
        return $this->db->affected_rows() > 0;
    }

    function get($to_email)
    {
        $this->db->limit(1);
        $this->db->where('to_email', $to_email);

        $query = $this->db->get($this->feedback_table);
        return $query->row_array();
    }

    function get_batch($to_email_list)
    {
        $this->db->select('to_email, type');
        $this->db->where_in('to_email', $to_email_list);

        $query = $this->db->get($this->feedback_table);
        return $query->result_array();
    }

    function stats()
    {
        $this->db->select('*, COUNT(*) AS count');
        $this->db->group_by('type');

        $query = $this->db->get($this->feedback_table);
        return $query->result_array();
    }
}