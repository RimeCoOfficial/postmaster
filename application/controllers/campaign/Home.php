<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
  public function index()
  {
    // $this->load->view('welcome_message');
  }

  public function send_email_test()
  {}

  public function send()
  {}

  public function archive($start_id = 1)
  {}

  public function show()
  {
    $this->load->model('promo/model_newsletter');
    $news = $this->model_newsletter->get_by_id($news_id);

    if (!empty($news))
    {
      switch ($type)
      {
        case 'tumblr_html':
        case 'html':
          header('Content-Type: text/html');
          break;
        case 'txt':
          header('Content-Type: text/plain');
          break;
        
        default:
          show_error('what the ..');
          break;
      }

      echo $news[ $type ]; die();
    }
    else
    {
      show_error('news_id not found');
    }
  }
}
