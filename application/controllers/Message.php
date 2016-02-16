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

  public function index($filter = NULL) // list-unsubscribe, type
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

  public function view($message_id = 0, $type = NULL)
  {
    $message = $this->lib_message->get($message_id);
    if (empty($message)) show_404();

    if ($type == 'html' OR $type == 'text' OR $type == 'html_input')
    {
      echo $message['body_'.$type]; die();
    }

    $local_view_data['message'] = $message;

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('message/view', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function create($list_id)
  {
    $this->load->library('lib_list_unsubscribe');
    $list_unsubscribe = $this->lib_list_unsubscribe->get($list_id);

    if (empty($list_unsubscribe))
    {
      show_error('List id: '.$list_id.' not found');
    }

    $local_view_data = [];
    $local_view_data['list_unsubscribe'] = $list_unsubscribe;

    $this->load->library('form_validation');
    if ($this->form_validation->run())
    {
      if (is_null($message_id = $this->lib_message->create(
        $this->form_validation->set_value('subject'),
        $list_id
      )))
      {
        show_error($this->lib_message->get_error_message());
      }
      else
      {
        redirect('message/edit/'.$message_id);
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('message/create', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function edit($message_id = 0)
  {
    $message = $this->lib_message->get($message_id);
    if (empty($message)) show_404();

    $local_view_data = [];
    $local_view_data['message'] = $message;

    if ($message['archived'] != '1000-01-01 00:00:00')
    {
      show_error('The message is archived and can not be modified');
    }

    $this->load->library('form_validation');
    if ($this->form_validation->run('message/edit'))
    {
      if (is_null($this->lib_message->update(
        $message,
        $this->form_validation->set_value('subject'),
        $this->form_validation->set_value('body_html_input'),
        $this->form_validation->set_value('reply_to_name'),
        $this->form_validation->set_value('reply_to_email')
      )))
      {
        show_error($this->lib_message->get_error_message());
      }
      else
      {
        $this->session->set_flashdata('alert', ['type' => 'success', 'message' => '<abbr class="text-nowrap pull-right" title="Patience Young Grasshopper&#13;http://emojicons.com/e/patience-young-grasshopper">&nbsp; ┬─┬﻿ ノ( ゜-゜ノ)</abbr>
          <strong>Updated:</strong> Message is successfuly updated']);
        redirect('message/view/'.$message_id);
      }
    }

    $view_data['main_content'] = $this->load->view('message/edit', $local_view_data, TRUE);

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();
    $this->load->view('base', $view_data);
  }

  public function publish($message_id = NULL)
  {
    $message = $this->lib_message->get($message_id);
    if (empty($message)) show_404();

    $local_view_data = [];
    $local_view_data['message'] = $message;

    if ($message['archived'] != '1000-01-01 00:00:00')
    {
      show_error('The message is archived and can not be modified');
    }

    $this->load->library('form_validation');

    // if ($message['type'] == 'transactional')
    // {
    //   $this->form_validation->set_data(['php_datetime_str' => 'now']);
    // }
    
    if ($this->form_validation->run('message/publish'))
    {
      if (is_null($this->lib_message->publish($message, $this->form_validation->set_value('php_datetime_str'))))
      {
        show_error($this->lib_message->get_error_message());
      }
      else
      {
        $this->session->set_flashdata('alert', ['type' => 'success', 'message' => '<abbr class="text-nowrap pull-right" title="Magical Table Flipping&#13;http://emojicons.com/e/magical-table-flipping">&nbsp; (/¯◡ ‿ ◡)/¯ ~ ┻━┻</abbr>
          <strong>Hooah</strong> /ˈhuːɑː/ Message was successfuly published']);
        redirect('message/view/'.$message_id);
      }
    }

    $view_data['main_content'] = $this->load->view('message/publish', $local_view_data, TRUE);

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();
    $this->load->view('base', $view_data);
  }

  public function archive($message_id = NULL)
  {
    if (is_null($this->lib_message->archive($message_id)))
    {
      show_error($this->lib_message->get_error_message());
    }
    else
    {
      $this->session->set_flashdata('alert', ['type' => 'warning', 'message' => '<abbr class="text-nowrap pull-right" title="Flipping Tables&#13;http://emojicons.com/e/flipping-tables">&nbsp; (╯°□°)╯︵ ┻━┻</abbr>
        <strong>Archive</strong> Message has been archived']);
      redirect('message/view/'.$message_id);
    }
  }

  public function unarchive($message_id = NULL)
  {
    if (is_null($type = $this->lib_message->unarchive($message_id)))
    {
      show_error($this->lib_message->get_error_message());
    }
    else
    {
      if ($type == 'transactional')
      {
        $this->session->set_flashdata('alert', ['type' => 'success', 'message' => '<abbr class="text-nowrap pull-right" title="Magical Table Flipping&#13;http://emojicons.com/e/magical-table-flipping">&nbsp; (/¯◡ ‿ ◡)/¯ ~ ┻━┻</abbr>
          <strong>Hooah</strong> /ˈhuːɑː/ Message was successfuly published']);
      }
      else
      {
        $this->session->set_flashdata('alert', ['type' => 'info', 'message' => '<abbr class="text-nowrap pull-right" title="Patience Young Grasshopper&#13;http://emojicons.com/e/patience-young-grasshopper">&nbsp; ┬─┬﻿ ノ( ゜-゜ノ)</abbr>
        <strong>Archive</strong> Message has been revert to draft']);
      }
      redirect('message/view/'.$message_id);
    }
  }

  public function send_test($message_id = NULL)
  {
    $message = $this->lib_message->get($message_id);
    if (empty($message)) show_404();

    $local_view_data = [];
    $local_view_data['message'] = $message;

    $this->load->library('form_validation');
    if ($this->form_validation->run('message/send_test'))
    {
      $to_email = $this->form_validation->set_value('email');

      $this->load->library('lib_send_email');
      if (is_null($this->lib_send_email->direct(
        $to_email, $message['subject'], $message['body_html'], $message['body_text']
      )))
      {
        show_error($this->lib_message->get_error_message());
      }
      else
      {
        $this->session->set_flashdata('alert', ['type' => 'info', 'message' => '<abbr class="text-nowrap pull-right" title="Glomp&#13;http://emojicons.com/e/glomp">&nbsp; (づ￣ ³￣)づ</abbr>
          <strong>On its way!</strong> Check your inbox ('.$to_email.')']);
        redirect('message/view/'.$message_id);
      }
    }
  }
}
