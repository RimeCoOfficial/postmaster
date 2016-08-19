<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scheduled extends CI_Controller
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

        $this->load->library('lib_request_scheduled');
    }

    // cd ~/Sites/postmaster && php index.php task scheduled autoresponder
    // cd /srv/www/postmaster/current && php index.php task scheduled autoresponder
    function autoresponder($count = 99)
    {
        echo 'Start Autoresponder'.PHP_EOL;

        if (is_running() === FALSE)
        {
            lock();
            while (TRUE)
            {
                $recipients = $this->lib_request_scheduled->get_autoresponder_recipients($count);
                if (empty($recipients))
                {
                    echo 'No task found!'.PHP_EOL;
                    break;
                }

                if (is_null($this->lib_request_scheduled->process_autoresponders($recipients)))
                {
                    show_error($this->lib_request_scheduled->get_error_message());
                }
            }
            unlock();
        }
    }

    // cd ~/Sites/postmaster && php index.php task scheduled campaign
    // cd /srv/www/postmaster/current && php index.php task scheduled campaign
    function campaign($count = 99)
    {
        echo 'Start Campaign'.PHP_EOL;

        if (is_running() === FALSE)
        {
            lock();
            while (TRUE)
            {
                $campaign_message = $this->lib_request_scheduled->get_latest_campaign();        
                if (empty($campaign_message))
                {
                    echo 'No task found!'.PHP_EOL;
                    break;
                }

                if (is_null($this->lib_request_scheduled->process_campaign($campaign_message, $count)))
                {
                    show_error($this->lib_request_scheduled->get_error_message());
                }
            }
            unlock();
        }
    }
}