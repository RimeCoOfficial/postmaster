<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller
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

  function index()
  {
    $local_view_data = [];

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/history', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }
}