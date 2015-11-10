<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactional extends CI_Controller
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
    $this->load->library('lib_transactional');
    $local_view_data['category_list'] = $this->lib_transactional->get_category_list();

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transactional/category_list', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function create_category()
  {
    $this->load->library('form_validation');
    
    $local_view_data = [];
    if ($this->form_validation->run())
    {
      $this->load->library('lib_transactional');
      if (is_null($this->lib_transactional->create_category(
        $this->form_validation->set_value('category'),
        $this->form_validation->set_value('reply_to_name'),
        $this->form_validation->set_value('reply_to_email')
      )))
      {
        show_error($this->lib_transactional->get_error_message());
      }
      else
      {
        redirect('transactional');
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transactional/category_create', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function category($cat_id)
  {
  }

  public function create()
  {}

  public function modify($transaction_id)
  {}

  public function show($transaction_id)
  {}
}