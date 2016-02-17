<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Open extends CI_Controller
{
  public function campaign($list_id)
  {}

  public function subscribe()
  {}

  public function unsubscribe($list_id = NULL)
  {
    $app_unsubscribe_uri = getenv('app_unsubscribe_uri');
    if ($app_unsubscribe_uri)
    {
      redirect(getenv('app_base_url').$app_unsubscribe_uri.http_build_query($this->input->get()));
    }

    $request_id = $this->input->get('request_id');
    $unsubscribe_key = $this->input->get('unsubscribe_key');

    $this->load->library('lib_archive');
    if (!is_null($archive_info = $this->lib_archive->get_info($request_id, $unsubscribe_key)))
    {
      $this->load->library('lib_recipient');
      $this->lib_recipient->unsubscribe_all($archive_info['recipient_id']);
    }

    $view_data['main_content'] = $this->load->view('open/unsubscribe', NULL, TRUE);
    $this->load->view('open/base', $view_data);
  }
}
