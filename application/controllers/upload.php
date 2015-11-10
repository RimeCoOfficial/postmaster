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

    // $this->load->library('lib_transaction');
  }

  function index()
  {
    $local_view_data = array();
    
    $config = [
      'upload_path' => '/tmp',
      'allowed_types' => 'gif|jpg|png',
      'file_name' => date('Ymd-Hms', time()),
      'file_ext_tolower' => TRUE,
      'overwrite' => TRUE,
      'max_size' => '2048',
      'max_width' => '1024',
      'max_height' => '768',
      // 'encrypt_name' => TRUE,
    ];
    $this->load->library('upload', $config);

    // if (!empty($this->input->post('upload_image')))
    {
      // die('pp');
      if (!$this->upload->do_upload('upload_image'))
      {
        $local_view_data['error'] = array('upload_image' => $this->upload->display_errors());
      }
      else
      {
        // file uploaded to /tmp
        $upload_data = $this->upload->data();

        // upload file to s3
        $this->load->config('api_key', TRUE);
        $config = $this->config->item('aws', 'api_key');
        $bucket = $config['s3_bucket'];

        $s3_key = $upload_data['file_name'];
        $tmp_file_name = $upload_data['full_path'];

        $this->load->library('composer/lib_aws');
        $s3_client = $this->lib_aws->get_s3();

        $result = $s3_client->putObject(array(
          'Bucket'     => $bucket,
          'Key'        => $s3_key,
          'SourceFile' => $tmp_file_name,
        ));

        // We can poll the object until it is accessible
        $s3_client->waitUntil('ObjectExists', array(
          'Bucket' => $bucket,
          'Key'    => $s3_key
        ));

        $s3_object_url = $result['ObjectURL'];

        // clean up
        unlink($upload_data['full_path']);

        // $local_view_data['upload_data'] = $upload_data;
        // $local_view_data['result'] = $result;
        $local_view_data['s3_object_url'] = $s3_object_url;
      }
    }

    $view_data['is_logged_in'] = $this->lib_auth->is_logged_in();

    $view_data['main_content'] = $this->load->view('upload_image', $local_view_data, TRUE);
    $this->load->view('base', $view_data);
  }
}