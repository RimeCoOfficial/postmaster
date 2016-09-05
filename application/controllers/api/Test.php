<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('api');

        $this->load->library('lib_api');
        if (is_null($this->lib_api->check_api_key())) output_error($this->lib_api->get_error_message());
    }

    /*
    # Request
    curl -X POST -i http://localhost/postmaster/api/test/direct -d "key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"

    # Response
    HTTP/1.1 200 OK
    Date: Tue, 23 Feb 2016 16:03:52 GMT
    Server: Apache/2.4.16 (Unix) PHP/5.6.16
    X-Powered-By: PHP/5.6.16
    Content-Length: 125
    Content-Type: application/json; charset=utf-8

    {
        "email_admin": "postmaster@example.com",
        "message_id": "000001530edf7371-e7cc889a-6dcd-4eb5-8b7d-e6cb67ad0c78-000000"
    }
    */
    public function direct()
    {
        $this->load->library('lib_send_email');
        if (is_null($result = $this->lib_send_email->direct(getenv('email_admin'), 'Foobar', '👍')))
        {
            output_error($this->lib_send_email->get_error_message());
        }
        else
        {
            $this->load->helper('api');
            $response = array('email_admin' => getenv('email_admin'), 'result' => $result);
            output($response);
        }
    }

    function error_php()
    {
        trigger_error('Blowing In The Wind (Live On TV, March 1963)', E_USER_ERROR);
    }

    function error_php_exception()
    {
        throw new Exception("No woman no cry", 1);
    }

    function error_general($status_code = 500)
    {
        show_error('Underneath the bridge.', $status_code);
    }
}
