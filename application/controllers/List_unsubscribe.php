<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_unsubscribe extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('lib_auth');
        if (!$this->lib_auth->is_logged_in())
        {
            redirect();
        }

        $this->load->library('lib_list_unsubscribe');
    }

    public function unsubscribe($request_id, $unsubscribe_key) {}


    public function index()
    {
        $local_view_data['list_unsubscribe'] = $this->lib_list_unsubscribe->get_list();

        $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

        $view_data['main_content'] = $this->load->view('list_unsubscribe/list', $local_view_data, TRUE);
        $this->load->view('base', $view_data);
    }

    public function create()
    {
        $local_view_data = [];

        $this->load->library('form_validation');
        if ($this->form_validation->run('list_unsubscribe/create'))
        {
            $list = $this->form_validation->set_value('list');

            if (is_null($this->lib_list_unsubscribe->create($list, $this->form_validation->set_value('type'))))
            {
                show_error($this->lib_list_unsubscribe->get_error_message());
            }
            else
            {
                redirect('list-unsubscribe/recipients/'.rawurlencode(strtolower($list)));
            }
        }

        $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

        $view_data['main_content'] = $this->load->view('list_unsubscribe/create', $local_view_data, TRUE);
        $this->load->view('base', $view_data);
    }

    public function edit($list = 0)
    {
        $list_unsubscribe = $this->lib_list_unsubscribe->get_by_name($list);
        if (empty($list_unsubscribe)) show_404();

        $local_view_data = [];
        $local_view_data['list_unsubscribe'] = $list_unsubscribe;

        $this->load->library('form_validation');
        if ($this->form_validation->run('list_unsubscribe/edit'))
        {
            $list = $this->form_validation->set_value('list');

            if (is_null($this->lib_list_unsubscribe->update($list_unsubscribe['list_id'], $list)))
            {
                show_error($this->lib_list_unsubscribe->get_error_message());
            }
            else
            {
                redirect('list-unsubscribe/recipients/'.rawurlencode(strtolower($list)));
            }
        }

        $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

        $view_data['main_content'] = $this->load->view('list_unsubscribe/edit', $local_view_data, TRUE);
        $this->load->view('base', $view_data);
    }

    public function recipients($list = 0)
    {
        $list_unsubscribe = $this->lib_list_unsubscribe->get_by_name($list);
        if (empty($list_unsubscribe)) show_404();

        $local_view_data = [];
        $local_view_data['list_unsubscribe'] = $list_unsubscribe;

        $this->load->library('lib_recipient');
        $local_view_data['recipient_list'] = $this->lib_recipient->get_list($list_unsubscribe['list_id']);

        $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

        $view_data['main_content'] = $this->load->view('list_unsubscribe/recipients', $local_view_data, TRUE);
        $this->load->view('base', $view_data);
    }

    // public function delete($list_id = 0)
    // {
    //   $this->lib_list_unsubscribe->delete($list_id);
    //   redirect('list-unsubscribe');
    // }
}