<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
  public function index()
  {
    trigger_error('Blowing In The Wind (Live On TV, March 1963)', E_USER_ERROR);
    
    $this->load->library('lib_auth');
    if ($this->lib_auth->is_logged_in())
    {
      redirect('stats');
    }

    $view['is_logged_in'] = FALSE;

    $view_data['main_content'] = $this->load->view('home', $view, TRUE);
    $this->load->view('base', $view_data);
  }
}
