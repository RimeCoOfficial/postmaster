<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Open extends CI_Controller
{
  public function campaign($list = NULL, $created_hash = NULL)
  {
    $this->load->library('lib_list_unsubscribe');
    $list_unsubscribe = $this->lib_list_unsubscribe->get_by_name($list);

    if (empty($list_unsubscribe)
      OR md5($list_unsubscribe['created']) != $created_hash
      OR $list_unsubscribe['type'] != 'campaign')
    {
      show_404();
    }

    $view_vars = [];
    $view_vars['list_unsubscribe'] = $list_unsubscribe;
    $view_vars['subscribe_uri'] = getenv('app_subscribe_uri');

    $this->load->library('lib_message');
    $view_vars['message_list'] = $this->lib_message->get_campaign_archive($list_unsubscribe['list_id']);

    $main_view_vars = [];
    $main_view_vars['main_content'] = $this->load->view('open/campaign', $view_vars, TRUE);
    $this->load->view('open/base', $main_view_vars);
  }

  public function subscribe($list = NULL)
  {
    // $app_subscribe_uri = getenv('app_subscribe_uri');
    // if ($app_subscribe_uri)
    // {
    //   redirect(getenv('app_base_url').'/'.$app_subscribe_uri.http_build_query($this->input->get()));
    // }

    $app_subscribe_uri = getenv('app_subscribe_uri');
    if ($app_subscribe_uri) show_404();

    $this->load->library('lib_list_unsubscribe');
    $list_unsubscribe = $this->lib_list_unsubscribe->get_by_name($list);

    if (empty($list_unsubscribe)
      OR $list_unsubscribe['type'] != 'campaign')
    {
      show_404();
    }

    $this->load->library('form_validation');
    if ($this->form_validation->run())
    {
      $this->load->library('lib_recipient');
      if (!is_null($this->lib_recipient->subscribe_all(
        $list_unsubscribe['list_id'],
        $this->form_validation->set_value('full_name'),
        $this->form_validation->set_value('email'))))
      {
        redirect('open/subscribe-success');
      }
    }

    $view_vars = [];
    $view_vars['list_unsubscribe'] = $list_unsubscribe;

    $main_view_vars = [];
    $main_view_vars['main_content'] = $this->load->view('open/subscribe', $view_vars, TRUE);
    $this->load->view('open/base', $main_view_vars);
  }

  public function subscribe_success()
  {
    $main_view_vars = [];
    $main_view_vars['main_content'] = $this->load->view('open/subscribe_success', NULL, TRUE);
    $this->load->view('open/base', $main_view_vars);
  }

  public function unsubscribe($request_id = NULL, $unsubscribe_key = NULL)
  {
    // $app_unsubscribe_uri = getenv('app_unsubscribe_uri');
    // if ($app_unsubscribe_uri)
    // {
    //   redirect(getenv('app_base_url').'/'.$app_unsubscribe_uri.http_build_query($this->input->get()));
    // }

    $app_unsubscribe_uri = getenv('app_unsubscribe_uri');
    if ($app_unsubscribe_uri) show_404();

    $this->load->library('lib_archive');
    if (!is_null($archive_info = $this->lib_archive->get_info($request_id, $unsubscribe_key)))
    {
      $this->load->library('lib_recipient');
      $this->lib_recipient->unsubscribe_all($archive_info['recipient_id']);
    }

    $main_view_vars = [];
    $main_view_vars['main_content'] = $this->load->view('open/unsubscribe', NULL, TRUE);
    $this->load->view('open/base', $main_view_vars);
  }
}
