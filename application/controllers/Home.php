<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
  public function index()
  {
    $this->load->library('lib_auth');
    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $this->load->view('welcome_message', $view_data);
  }
}
