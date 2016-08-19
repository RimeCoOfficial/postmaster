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
    function process($count = 9)
    {
        echo 'Start process'.PHP_EOL;
        $this->load->library('lib_request');

        if (is_running() === FALSE)
        {
            lock();
            while (TRUE)
            {
                $messages = $this->lib_request->get_to_process($count);
                if (empty($messages))
                {
                    echo 'No task found!'.PHP_EOL;
                    break;
                }

                if (is_null($this->lib_request->process($messages)))
                {
                    show_error($this->lib_request->get_error_message());
                }
            }
            unlock();
        }
    }

    // cd ~/Sites/postmaster && php index.php task message send
    // cd /srv/www/postmaster/current && php index.php task message send
    function send($count = 9)
    {
        echo 'Start send'.PHP_EOL;
        $this->load->library('lib_archive');

        if (is_running() === FALSE)
        {
            lock();
            while (TRUE)
            {
                $messages = $this->lib_archive->get_unsent($count);
                if (empty($messages))
                {
                    echo 'No task found!'.PHP_EOL;
                    break;
                }

                if (is_null($this->lib_archive->send($messages)))
                {
                    show_error($this->lib_archive->get_error_message());
                }
            }
            unlock();
        }
    }

    // cd ~/Sites/postmaster && php index.php task message archive
    // cd /srv/www/postmaster/current && php index.php task message archive
    function archive($count = 9)
    {
        echo 'Start archive'.PHP_EOL;
        $this->load->library('lib_archive');

        if (is_running() === FALSE)
        {
            lock();
            while (TRUE)
            {
                $messages = $this->lib_archive->get_unarchive($count);

                if (empty($messages))
                {
                    echo 'No task found!'.PHP_EOL;
                    break;
                }

                if (is_null($this->lib_archive->archive($messages)))
                {
                    show_error($this->lib_archive->get_error_message());
                }
            }
            unlock();
        }
    }
}