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

    $this->load->library('lib_transaction');
  }

  public function index($filter = NULL)
  {
    $local_view_data['list'] = $this->lib_transaction->get_list();

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/list', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function create()
  {
    $local_view_data = [];

    $this->load->library('form_validation');
    if ($this->form_validation->run())
    {
      if (is_null($message_id = $this->lib_transaction->create(
        $this->form_validation->set_value('subject')
      )))
      {
        show_error($this->lib_transaction->get_error_message());
      }
      else
      {
        redirect('transaction/message/modify/'.$message_id);
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/create', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function modify($message_id = 0)
  {
    $message = $this->lib_transaction->get($message_id);
    if (empty($message)) show_404();

    $local_view_data = [];
    $local_view_data['message'] = $message;

    if ($message['archived'] != '1000-01-01 00:00:00')
    {
      $view_data['main_content'] = $this->load->view('transaction/archive', $local_view_data, TRUE);
    }
    else
    {
      $this->load->library('lib_label');
      $label_list = $this->lib_label->get_list();

      $label_keys = [NULL => '&mdash;'];
      foreach ($label_list as $label) $label_keys[ $label['label_id'] ] = $label['name'];
      set_dropdown_options('label_id', $label_keys);

      $this->load->library('form_validation');
      if ($this->form_validation->run('transaction/message/modify'))
      {
        if (is_null($this->lib_transaction->modify(
          $message_id,
          $this->form_validation->set_value('label_id'),
          $this->form_validation->set_value('subject'),
          $this->form_validation->set_value('body_html_input'),
          $this->form_validation->set_value('reply_to_name'),
          $this->form_validation->set_value('reply_to_email')
        )))
        {
          show_error($this->lib_transaction->get_error_message());
        }
        else
        {
          redirect('transaction/message/modify/'.$message_id);
        }
      }

      $view_data['main_content'] = $this->load->view('transaction/modify', $local_view_data, TRUE);
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();
    $this->load->view('base', $view_data);
  }

  public function archive($message_id = 0)
  {
    $this->lib_transaction->archive($message_id);
    redirect('transaction/message/modify/'.$message_id);
  }

  public function unarchive($message_id = 0)
  {
    $this->lib_transaction->unarchive($message_id);
    redirect('transaction/message/modify/'.$message_id);
  }
}