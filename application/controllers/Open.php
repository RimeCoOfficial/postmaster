<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Open extends CI_Controller
{
  public function campaign($list_id)
  {}

  
  public function message($request_id, $web_version_key)
  {
    // @suvozit: disabled messages web view
    //  - might cause scurity isses
    //  - not widly used in popular apps
    $this->load->library('lib_auth');
    if (!$this->lib_auth->is_logged_in())
    {
      redirect();
    }

    $this->load->library('lib_message_archive');
    $message = $this->lib_message_archive->get($request_id, $web_version_key);
    if (empty($message)) show_404();

    echo $message['body_html'];
    die();
  }

  public function unsubscribe($list_id = NULL)
  {
    $app_unsubscribe_uri = getenv('app_unsubscribe_uri');
    if ($app_unsubscribe_uri)
    {
      redirect(getenv('app_base_url').$app_unsubscribe_uri.http_build_query($this->input->get()));
    }

    $request_id = $this->input->get('archive_id');
    $unsubscribe_key = $this->input->get('unsubscribe_key');

    $this->load->library('lib_message_archive');
    if (!is_null($archive_info = $this->lib_message_archive->get_info($request_id, $unsubscribe_key)))
    {
      $this->lib_list_recipient->unsubscribe_all($archive_info['list_recipient_id']);
    }

    $view_data['main_content'] = $this->load->view('open/unsubscribe', NULL, TRUE);
    $this->load->view('open/base', $view_data);
  }
}