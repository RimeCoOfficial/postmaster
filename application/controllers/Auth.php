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
    if ($this->lib_auth->is_logged_in())
    {
      redirect();
    }

    if (is_null($login_email_key = $this->lib_auth->sign_in()))
    {
      show_error($this->lib_auth->get_error_message());
    }

    if (ENVIRONMENT == 'development') echo anchor('auth/verify/'.$login_email_key); die();

    // send email
    $email_data = ['login_email_key' => $login_email_key];
    $this->load->library('lib_send_email');
    $this->lib_send_email->general(getenv('email_admin'), app_name().' Login', 'auth/verify', $email_data);

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('signin', NULL, TRUE);
    $this->load->view('base', $view_data);
  }

  public function verify($login_email_key)
  {
    if (is_null($this->lib_auth->verify($login_email_key)))
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
