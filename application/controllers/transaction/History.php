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

    $this->load->library('lib_message_send');
  }

  function index()
  {
    $local_view_data = [];

    $local_view_data['message_send_history'] = $this->lib_message_send->get_list('transaction');

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/history', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }
}