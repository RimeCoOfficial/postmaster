<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller
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
    $this->load->library('lib_category');
    $local_view_data['category_list'] = $this->lib_category->get_list();

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/category/list', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function create()
  {
    $this->load->library('form_validation');
    
    $local_view_data = [];
    if ($this->form_validation->run('transaction/category/create'))
    {
      $this->load->library('lib_category');
      if (is_null($this->lib_category->create(
        $this->form_validation->set_value('category')
      )))
      {
        show_error($this->lib_category->get_error_message());
      }
      else
      {
        redirect('transaction/category');
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/category/create', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  public function modify($category_id)
  {
    $local_view_data = [];

    $this->load->library('lib_category');
    $local_view_data['category'] = $this->lib_category->get($category_id);

    if (empty($local_view_data['category'])) show_error('category not found');

    $this->load->library('form_validation');
    
    if ($this->form_validation->run('transaction/category/modify'))
    {
      if (is_null($this->lib_category->modify(
        $category_id,
        $this->form_validation->set_value('category')
      )))
      {
        show_error($this->lib_category->get_error_message());
      }
      else
      {
        redirect('transaction/category');
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('transaction/category/modify', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }
}