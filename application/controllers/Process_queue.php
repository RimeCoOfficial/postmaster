<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// https://sesblog.amazon.com/post/TxJE1JNZ6T9JXK/Handling-Bounces-and-Complaints
class Process_queue extends CI_Controller
{
  // success@simulator.amazonses.com
  // bounce@simulator.amazonses.com
  // ooto@simulator.amazonses.com
  // complaint@simulator.amazonses.com
  // suppressionlist@simulator.amazonses.com
  function __construct()
  {
    parent::__construct();
    
    if (!is_cli())
    {
      show_error('CLI request only.');
    }

    $this->load->helper('cron');
    echo 'Email Status'.PHP_EOL;
  }

  // cd ~/Sites/email && php index.php task email_status index bounces
  // cd /srv/www/email/current && php index.php task email_status index bounces
  function index($type = 'bounces') //  type = bounces, complaints, deliveries
  {
    echo 'Start Notification'.PHP_EOL;
    $this->load->library('email/lib_email_status');

    if (is_running() === FALSE)
    {
      lock();
      while (TRUE)
      {
        if (is_null($this->lib_email_status->process_queue($type)))
        {
          show_error($this->lib_email_status->get_error_message());
        }
      }
      unlock();
    }
  }
}