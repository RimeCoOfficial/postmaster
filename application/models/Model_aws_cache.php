<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_aws_cache extends CI_Model
{
    private $aws_cache_table  = 'aws_cache';
    private $cache_age        = 15; // mins

    function store($service, $method, $response)
    {
        $record = array(
            'service' => $service,
            'method' => $method,
            'response' => $response,
        );

        $this->db->insert_on_duplicate_update($this->aws_cache_table, $record);
    }

    function get($service, $method)
    {
        $this->db->limit(1);

        $this->db->where('service', $service);
        $this->db->where('method', $method);

        $query = $this->db->get($this->aws_cache_table);
        return $query->row_array();
    }

    function update_method($service, $method)
    {
        $this->db->where('service', $service);
        $this->db->where('method', $method);

        $this->db->set('updated', '1000-01-01 00:00:00');
        $this->db->update($this->aws_cache_table);
    }

    function update_service($service)
    {
        $this->db->where('service', $service);

        $this->db->set('updated', '1000-01-01 00:00:00');
        $this->db->update($this->aws_cache_table);
    }
}