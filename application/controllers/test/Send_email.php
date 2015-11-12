<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_email extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    // if (!is_cli())
    // {
    //   show_error('CLI request only.');
    // }
  }

  // cd ~/Sites/log-pixel && php index.php test send_email test
  // cd /srv/www/log_pixel/current && php index.php test send_email test
  public function test()
  {
    $this->load->library('lib_send_email');
    echo '<pre>' . $this->lib_send_email->general(getenv('email_debug'), 'foo', 'bar') . '</pre>';
  }

  function error_php()
  {
    trigger_error('Blowing In The Wind (Live On TV, March 1963)', E_USER_ERROR);
  }

  function error_php_exception()
  {
    throw new Exception("No woman no cry", 1);
  }

  function error_general($status_code = 500)
  {
    show_error('Underneath the bridge.', $status_code);
  }
}