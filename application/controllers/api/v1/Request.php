<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('api');
        
        $this->load->library('lib_api');
        if (is_null($this->lib_api->check_api_key())) output_error($this->lib_api->get_error_message());

        $this->load->library('lib_message');
    }

    /*
    curl -X POST -i http://localhost/postmaster/api/v1/request/transactional/1 -d \
    "key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\
    &recipient_id=visitor-ecfa94f6c8ef80696ba6ee7d2434cbf7@suvozit.com\
    &to_name=Shubhajit Saha\
    &to_email=www@suvozit.com\
    &pseudo_vars[foo]=bar"
    */
    public function transactional($message_id = 0)
    {
        if (is_null($result = $this->lib_message->add_request($message_id)))
        {
            output_error($this->lib_message->get_error_message());
        }

        output($result);
    }
}
