<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  public function campaign()
  {}

  public function message($request_id, $web_version_key)
  {
    $this->load->library('lib_message_archive');
    $message = $this->lib_message_archive->get($request_id, $web_version_key);
    if (empty($message)) show_404();

    echo $message['body_html'];
    die();
  }
}