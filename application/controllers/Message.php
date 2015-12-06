<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->library('lib_auth');
    if (!$this->lib_auth->is_logged_in())
    {
      redirect();
    }

    $this->load->library('lib_message');
  }

  public function index($filter = NULL)
  {
    $local_view_data['list'] = $this->lib_message->get_list();

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('message/list', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function show($message_id = 0)
  {
    $message = $this->lib_message->get($message_id);
    if (empty($message)) show_404();

    echo is_null($message['body_html']) ? $message['body_html_input'] : $message['body_html'];
    die();
  }

  public function archive($request_id, $verify_key)
  {
    $this->load->library('lib_message_archive');
    $message = $this->lib_message_archive->get($request_id, $verify_key);
    if (empty($message)) show_404();

    echo $message['body_html'];
    die();
  }
}
