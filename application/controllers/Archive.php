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

    $this->load->library('lib_message');
  }

  public function index()
  {}

  public function request($request_id, $web_version_key)
  {
    $this->load->library('lib_message_archive');
    $message = $this->lib_message_archive->get($request_id, $web_version_key);
    if (empty($message)) show_404();

    echo $message['body_html'];
    die();
  }
}