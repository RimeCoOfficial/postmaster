<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stats extends CI_Controller
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

    public function index()
    {
        $local_view_data = [];

        $this->load->library('lib_feedback');
        $local_view_data['feedback'] = $this->lib_feedback->stats();

        $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

        $view_data['main_content'] = $this->load->view('stats/feedback', $local_view_data, TRUE);
        $this->load->view('base', $view_data);
    }

    public function history()
    {
        $local_view_data = [];

        $this->load->library('lib_archive');
        $local_view_data['archive_list'] = $this->lib_archive->get_list();

        $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

        $view_data['main_content'] = $this->load->view('stats/history', $local_view_data, TRUE);
        $this->load->view('base', $view_data);
    }
}
