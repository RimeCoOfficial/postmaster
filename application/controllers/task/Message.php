<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    
    if (!is_cli())
    {
      show_error('CLI request only.');
    }

    $this->load->helper('cron');
    echo 'Message'.PHP_EOL;
  }

  // cd ~/Sites/postmaster && php index.php task message process
  // cd /srv/www/postmaster/current && php index.php task message process
  function process($count = 99)
  {
    echo 'Start process'.PHP_EOL;
    $this->load->library('lib_message_history');

    if (is_running() === FALSE)
    {
      lock();
      while (TRUE)
      {
        $messages = $this->lib_message_history->get_to_process($count);
        if (empty($messages))
        {
          echo 'No task found!';
          break;
        }

        if (is_null($this->lib_message_history->process($messages)))
        {
          show_error($this->lib_message_history->get_error_message());
        }
      }
      unlock();
    }
  }

  // cd ~/Sites/postmaster && php index.php task message send
  // cd /srv/www/postmaster/current && php index.php task message send
  function send($count = 99)
  {
    echo 'Start send'.PHP_EOL;
    $this->load->library('lib_message_send');

    if (is_running() === FALSE)
    {
      lock();
      while (TRUE)
      {
        $messages = $this->lib_message_send->get_to_send($count);
        if (empty($messages))
        {
          echo 'No task found!';
          break;
        }

        if (is_null($this->lib_message_send->send($messages)))
        {
          show_error($this->lib_message_send->get_error_message());
        }
      }
      unlock();
    }
  }
}