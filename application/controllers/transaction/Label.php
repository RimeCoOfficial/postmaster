<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class label extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->library('lib_auth');
    if (!$this->lib_auth->is_logged_in())
    {
      redirect();
    }
  }

  public function index()
  {
    $this->load->library('lib_label');
    $local_view_data['label_list'] = $this->lib_label->get_list();

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/label/list', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function create()
  {
    $local_view_data = [];

    $this->load->library('form_validation');
    if ($this->form_validation->run('transaction/label/create'))
    {
      $this->load->library('lib_label');
      if (is_null($this->lib_label->create(
        $this->form_validation->set_value('label')
      )))
      {
        show_error($this->lib_label->get_error_message());
      }
      else
      {
        redirect('transaction/label');
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/label/create', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function modify($label_id)
  {
    $local_view_data = [];

    $this->load->library('lib_label');
    $local_view_data['label'] = $this->lib_label->get($label_id);

    if (empty($local_view_data['label'])) show_error('label not found');

    $this->load->library('form_validation');
    if ($this->form_validation->run('transaction/label/modify'))
    {
      if (is_null($this->lib_label->modify(
        $label_id,
        $this->form_validation->set_value('label')
      )))
      {
        show_error($this->lib_label->get_error_message());
      }
      else
      {
        redirect('transaction/label');
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/label/modify', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }
}