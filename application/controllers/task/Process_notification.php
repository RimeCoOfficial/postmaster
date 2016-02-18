<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process_notification extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    
    if (!is_cli())
    {
      show_error('CLI request only.');
    }

    $this->load->helper('cron');
    echo 'Process notification queue'.PHP_EOL;
  }

  // https://sesblog.amazon.com/post/TxJE1JNZ6T9JXK/Handling-Bounces-and-Complaints

  // success@simulator.amazonses.com
  // bounce@simulator.amazonses.com
  // ooto@simulator.amazonses.com
  // complaint@simulator.amazonses.com
  // suppressionlist@simulator.amazonses.com

  // cd ~/Sites/postmaster && php index.php task process_notification ses
  // cd /srv/www/postmaster/current && php index.php task process_notification ses
  function ses() //  type = bounces, complaints, deliveries
  {
    echo 'Start Notification'.PHP_EOL;
    $this->load->library('lib_feedback');

    if (is_running() === FALSE)
    {
      lock();
      while (TRUE)
      {
        if (is_null($this->lib_feedback->process_notification()))
        {
          show_error($this->lib_feedback->get_error_message());
        }
      }
      unlock();
    }
  }
}