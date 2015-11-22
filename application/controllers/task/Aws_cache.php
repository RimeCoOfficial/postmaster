<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aws_cache extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    
    if (!is_cli())
    {
      show_error('CLI request only.');
    }

    $this->load->helper('cron');
    echo 'Update AWS cache'.PHP_EOL;
  }

  // cd ~/Sites/postmaster && php index.php task aws_cache update s3 listObjects
  // cd /srv/www/postmaster/current && php index.php task aws_cache update s3 listObjects
  function update($service, $method)
  {
    echo 'Start Notification'.PHP_EOL;
    $this->load->library('lib_feedback');

    if (is_running() === FALSE)
    {
      lock();
      switch ($service.':'.$method)
      {
        case 's3:listObjects':
          $this->load->library('lib_s3_object');
          $this->lib_s3_object->update($service, $method);
          break;
        
        default:
          echo 'oops!!';
          break;
      }
      unlock();
    }
  }
}