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

    $login_email_key = NULL;
    $email_webmaster = NULL;

    $this->load->library('form_validation');
    if ($this->form_validation->run())
    {
      $email_webmaster = $this->form_validation->set_value('email');

      if (!is_null($login_email_key = $this->lib_auth->sign_in($email_webmaster)))
      {
        // send email
        $this->load->library('lib_send_email');
        $this->lib_send_email->direct($email_webmaster, 'Sign in', anchor('auth/verify/'.$login_email_key, NULL, 'target="_blank"'));
      }
    }

    $view_data['login_email_key'] = $login_email_key;
    $view_data['email_webmaster'] = $email_webmaster;

    $view_data['main_content'] = $this->load->view('open/sign_in', $view_data, TRUE);
    $this->load->view('open/base', $view_data);

    return NULL;
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
