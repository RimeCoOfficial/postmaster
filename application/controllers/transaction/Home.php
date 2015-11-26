<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
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

  public function modify($message_id)
  {
    $transaction = $this->lib_transaction->get($message_id);
    if (empty($transaction)) show_404();

    $local_view_data = [];
    $local_view_data['transaction'] = $transaction;

    $this->load->library('lib_label');
    $label_list = $this->lib_label->get_list();

    $label_keys = [NULL => '&mdash;'];
    foreach ($label_list as $label) $label_keys[ $label['label_id'] ] = $label['name'];
    set_dropdown_options('label_id', $label_keys);

    $this->load->library('form_validation');
    if ($this->form_validation->run('transaction/home/modify'))
    {
      if (is_null($this->lib_transaction->modify(
        $message_id,
        $this->form_validation->set_value('label_id')
      )))
      {
        show_error($this->lib_transaction->get_error_message());
      }
      // else
      // {
      //   redirect('transaction');
      // }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/modify', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function delete($message_id)
  {
    $this->lib_transaction->delete($message_id);
    redirect('transaction');
  }
}