<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class S3 extends CI_Controller
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
    redirect('s3/upload');
  }

  function object()
  {
    $prefix = $this->input->get('prefix');

    $this->load->helper('number');

    $this->load->config('api_key', TRUE);
    $config = $this->config->item('aws', 'api_key');

    $local_view_data['aws_config'] = $config;
    $local_view_data['s3_object_list'] = $this->lib_s3_object->get_list($prefix);

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('s3/list', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }

  function upload($prefix = NULL) // inline-image, file, import
  {
    $local_view_data = array();
    
    $this->config->load('upload_s3', TRUE);
    $prefixes = $this->config->item('upload_s3');
    
    if (empty($prefixes[ $prefix ]))
    {
      $local_view_data['prefixes'] = $prefixes;
      $view_data['main_content'] = $this->load->view('s3/upload_select', $local_view_data, TRUE);
    }
    else
    {
      $config = $prefixes[ $prefix ];

      $local_view_data['prefix'] = $prefix;

      $prefix = 'upload/'.$prefix;

      $this->load->library('upload', $config['upload']);
      if ( ! $this->upload->do_upload('upload_s3_object'))
      {
        $local_view_data['error'] = array('upload_s3_object' => $this->upload->display_errors());
      }
      else
      {
        // file uploaded to /tmp/ci/upload
        $upload = $this->upload->data();

        if (is_null($s3_object_url = $this->lib_s3_object->upload($upload, $prefix)))
        {
          show_error($this->lib_s3_object->get_error_message());
        }

        $redirect_url = 's3/object?prefix='.urlencode($prefix.'/');

        $this->session->set_flashdata('alert', ['type' => 'success', 'message' => '<strong>Uploaded</strong>: '.$s3_object_url]);
        redirect($redirect_url);
      }

      $view_data['main_content'] = $this->load->view('s3/upload', $local_view_data, TRUE);
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();
    $this->load->view('base', $view_data);
  }
}