<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archive extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->library('lib_auth');
    if (!$this->lib_auth->is_logged_in())
    {
      redirect();
    }

    $this->load->library('lib_message_archive');
  }

  public function index($filter = NULL)
  {
    $local_view_data['list'] = $this->lib_message_archive->get_list();

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transactional/list', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }
}