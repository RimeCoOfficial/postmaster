<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scheduled_messages extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    
    if (!is_cli())
    {
      show_error('CLI request only.');
    }

    $this->load->helper('cron');
    echo 'Scheduled Message'.PHP_EOL;
  }

  // cd ~/Sites/postmaster && php index.php task scheduled_messages autoresponder
  // cd /srv/www/postmaster/current && php index.php task scheduled_messages autoresponder
  function autoresponder($count = 999)
  {
    echo 'Start Autoresponder'.PHP_EOL;
    $this->load->library('lib_message_scheduled');

    if (is_running() === FALSE)
    {
      lock();
      while (TRUE)
      {
        $list_recipients = $this->lib_message_scheduled->get_autoresponders($count);
        if (empty($list_recipients))
        {
          echo 'No task found!'.PHP_EOL;
          break;
        }

        if (is_null($this->lib_message_scheduled->process_autoresponders($list_recipients)))
        {
          show_error($this->lib_message_scheduled->get_error_message());
        }
      }
      unlock();
    }
  }
}