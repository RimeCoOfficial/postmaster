<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller
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

  public function index($filter = NULL) // 'show_archived|category:notification'
  {
    $local_view_data['list'] = $this->lib_transaction->get_list();

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/list', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function create()
  {
    $this->load->library('form_validation');
    
    $local_view_data = [];
    if ($this->form_validation->run())
    {
      if (is_null($transction_id = $this->lib_transaction->create(
        $this->form_validation->set_value('subject')
      )))
      {
        show_error($this->lib_transaction->get_error_message());
      }
      else
      {
        redirect('transaction/modify/'.$transction_id);
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/create', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function modify($transaction_id)
  {
    $local_view_data = [];

    $local_view_data['transaction'] = $this->lib_transaction->get($transaction_id);

    if ($this->form_validation->run())
    {
      if (is_null($this->lib_transaction->modify(
        $transaction_id,
        $this->form_validation->set_value('subject'),
        $this->form_validation->set_value('reply_to_name'),
        $this->form_validation->set_value('reply_to_email')
      )))
      {
        show_error($this->lib_transaction->get_error_message());
      }
      else
      {
        // redirect('transaction');
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/modify', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function show($transaction_id)
  {}
}