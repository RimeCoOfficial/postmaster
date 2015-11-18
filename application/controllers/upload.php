<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->library('lib_auth');
    if (!$this->lib_auth->is_logged_in())
    {
      redirect();
    }

    $this->load->library('lib_s3_object');
  }

  function index()
  {
    $this->load->config('api_key', TRUE);
    $config = $this->config->item('aws', 'api_key');
    $bucket = $config['s3_bucket'];

    $local_view_data['aws_config'] = $config;
    $local_view_data['upload_list'] = $this->lib_s3_object->get_list();

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('upload/list', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  function go($type) // inline-image, attachment, import
  {
    $local_view_data = array();
    
    $this->config->load('upload_s3_object', TRUE);
    $config = $this->config->item($type, 'upload_s3_object');
    
    if (empty($config))
    {
      show_error('type not found');
    }
    $local_view_data['type'] = $type;

    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('upload_s3_object'))
    {
      $local_view_data['error'] = array('upload_s3_object' => $this->upload->display_errors());
    }
    else
    {
      // file uploaded to /tmp
      $upload = $this->upload->data();

      if (is_null($s3_object_url = $this->lib_s3_object->upload($upload, $type)))
      {
        show_error($this->lib_s3_object->get_error_message());
      }

      // $local_view_data['upload'] = $upload;
      // $local_view_data['result'] = $result;
      $local_view_data['s3_object_url'] = $s3_object_url;
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('upload/form', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  function delete($key)
  {}
}