<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Open extends CI_Controller
{
  public function campaign($list_id = NULL, $created_hash = NULL)
  {
    $this->load->library('lib_list_unsubscribe');
    $list_unsubscribe = $this->lib_list_unsubscribe->get($list_id);

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
    $view_vars['message_list'] = $this->lib_message->get_campaign_archive($list_id);

    $main_view_vars = [];
    $main_view_vars['main_content'] = $this->load->view('open/campaign', $view_vars, TRUE);
    $this->load->view('open/base', $main_view_vars);
  }

  public function subscribe()
  {}

  public function unsubscribe($list_id = NULL)
  {
    $app_unsubscribe_uri = getenv('app_unsubscribe_uri');
    if ($app_unsubscribe_uri)
    {
      redirect(getenv('app_base_url').'/'.$app_unsubscribe_uri.http_build_query($this->input->get()));
    }

    $request_id = $this->input->get('request_id');
    $unsubscribe_key = $this->input->get('unsubscribe_key');

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
