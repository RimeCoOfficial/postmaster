<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stats extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    
    $this->data = array();
    
    $this->load->library('user/lib_user_login');
    $logged_in_user = $this->lib_user_login->get_user();
    
    if (empty($logged_in_user))
    {
      if (!$this->input->is_ajax_request())
      {
        redirect('auth/signin?redirect='.rawurlencode(uri_string_q()));
      }
      else show_error('user must sign in');
    }
    
    if ( ! ($logged_in_user['permission'] == 'founder'))
    {
      show_error('unauthorized permission');
    }

    $this->data['logged_in_user'] = $logged_in_user;
  }

  public function index() { redirect('tool/stats/email'); }

  public function email()
  {
    $this->data['page_title'] = 'Email statistics';

    $local_data = array();

    $this->load->library('email/lib_email_status');
    $local_data['stats'] = $this->lib_email_status->stats();

    $this->data['main_content'] = $this->load->view('tool/stats_email', $local_data, TRUE);
    $this->data['main_content'] = $this->load->view('tool/base', $this->data, TRUE);
    $this->load->view('base', $this->data);
  }
}