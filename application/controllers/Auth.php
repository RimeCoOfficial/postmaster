<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('lib_auth');
  }

  public function sign_in()
  {
    if (is_null($session_id = $this->lib_auth->sign_in()))
    {
      show_error($this->lib_auth->get_error_message());
    }

    var_dump($session_id); die();
  }

  public function verify($session_id)
  {
    if (is_null($this->lib_auth->verify($session_id)))
    {
      show_error($this->lib_auth->get_error_message());
    }

    redirect();
  }

  public function sign_out()
  {
    $this->lib_auth->sign_out();

    redirect();
  }
}
