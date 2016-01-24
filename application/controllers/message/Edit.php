<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends CI_Controller
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

  function index()
  {

  }
}