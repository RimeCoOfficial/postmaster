<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller
{
  public function campaign()
  {}

  
  public function message($request_id, $web_version_key)
  {
    // @suvozit: disabled messages web view
    //  - might cause scurity isses
    //  - not widly used in popular apps
    $this->load->library('lib_auth');
    if (!$this->lib_auth->is_logged_in())
    {
      redirect();
    }

    $this->load->library('lib_message_archive');
    $message = $this->lib_message_archive->get($request_id, $web_version_key);
    if (empty($message)) show_404();

    echo $message['body_html'];
    die();
  }
}