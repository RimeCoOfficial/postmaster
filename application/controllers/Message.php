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

  public function create()
  {
    $local_view_data = [];
    if ($this->form_validation->run())
    {
      if (is_null($message_id = $this->lib_message->create(
        $this->form_validation->set_value('subject'),
        $this->form_validation->set_value('category_id')
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

  public function modify($message_id)
  {
    $local_view_data = [];

    $local_view_data['message'] = $this->lib_message->get($message_id);

    if ($this->form_validation->run())
    {
      if (is_null($this->lib_message->modify(
        $message_id,
        $this->form_validation->set_value('subject'),
        $this->form_validation->set_value('reply_to_name'),
        $this->form_validation->set_value('reply_to_email'),
        $this->form_validation->set_value('message_html')
      )))
      {
        show_error($this->lib_message->get_error_message());
      }
      // else
      // {
      //   redirect('message');
      // }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('message/modify', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function show($message_id)
  {
    $message = $this->lib_message->get($message_id);
    echo $message['message_html'];
  }
}
