<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('lib_auth');
        if (!$this->lib_auth->is_logged_in())
        {
            redirect();
        }
    }

    public function index($filter = NULL)
    {
        $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

        $view_data['main_content'] = $this->load->view('settings', NULL, TRUE);
        $this->load->view('base', $view_data);
    }
}
