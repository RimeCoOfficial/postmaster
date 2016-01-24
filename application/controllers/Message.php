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

  public function index($type = NULL)
  {
    $local_view_data['list'] = $this->lib_message->get_list();

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('message/list', $local_view_data, TRUE);
    $this->load->view('base', $view_data);

    // $this->load->library('lib_message');
    // $local_view_data['list'] = $this->lib_message->get_list_transactional();

    // $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    // $view_data['main_content'] = $this->load->view('message/list', $local_view_data, TRUE);
    // $this->load->view('base', $view_data);

  }

  public function show($message_id = 0, $html_only = FALSE)
  {
    $message = $this->lib_message->get($message_id);
    if (empty($message)) show_404();

    if ($html_only)
    {
      echo $message['body_html'];
      die();
    }

    $local_view_data['message'] = $message;

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('message/show', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function create()
  {
    $local_view_data = [];

    $this->load->library('form_validation');
    if ($this->form_validation->run())
    {
      if (is_null($message_id = $this->lib_message->create(
        $this->form_validation->set_value('subject'),
        $this->form_validation->set_value('owner'),
        $this->form_validation->set_value('list_id')
      )))
      {
        show_error($this->lib_message->get_error_message());
      }
      else
      {
        redirect('message/modify/'.$message_id);
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('message/create', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function modify($message_id = 0)
  {
    $message = $this->lib_message->get($message_id);
    if (empty($message)) show_404();

    $local_view_data = [];
    $local_view_data['message'] = $message;

    if ($message['archived'] != '1000-01-01 00:00:00')
    {
      $view_data['main_content'] = $this->load->view('message/archive', $local_view_data, TRUE);
    }
    else
    {
      $this->load->library('form_validation');
      if ($this->form_validation->run('message/modify'))
      {
        // var_dump($this->form_validation->set_value('owner')); die();
        
        if (is_null($this->lib_message->modify(
          $message_id,
          $this->form_validation->set_value('subject'),
          $this->form_validation->set_value('owner'),
          $this->form_validation->set_value('list_id'),
          NULL,
          $this->form_validation->set_value('body_html_input'),
          $this->form_validation->set_value('reply_to_name'),
          $this->form_validation->set_value('reply_to_email')
        )))
        {
          show_error($this->lib_message->get_error_message_transactional());
        }
        else
        {
          redirect('message/modify/'.$message_id);
        }
      }

      $view_data['main_content'] = $this->load->view('message/modify', $local_view_data, TRUE);
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();
    $this->load->view('base', $view_data);
  }

  public function archive($message_id = 0)
  {
    $this->lib_message->archive_transactional($message_id);
    redirect('message/modify/'.$message_id);
  }

  public function unarchive($message_id = 0)
  {
    $this->lib_message->unarchive_transactional($message_id);
    redirect('message/modify/'.$message_id);
  }
}
