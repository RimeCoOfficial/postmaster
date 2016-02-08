<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
  public function index()
  {
    $this->load->library('lib_auth');
    if ($this->lib_auth->is_logged_in())
    {
      redirect('stats');
    }

    $view_data['main_content'] = $this->load->view('home', NULL, TRUE);
    $this->load->view('base', $view_data);
  }
}
