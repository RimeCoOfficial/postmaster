<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign extends CI_Controller
{
  public function index()
  {
    // $this->load->view('welcome_message');
  }

  public function send_email_test()
  {}

  public function send()
  {}

  public function archive($start_id = 1)
  {}

  public function show()
  {
    $this->load->model('promo/model_newsletter');
    $news = $this->model_newsletter->get_by_id($news_id);

    if (!empty($news))
    {
      switch ($type)
      {
        case 'tumblr_html':
        case 'html':
          header('Content-Type: text/html');
          break;
        case 'txt':
          header('Content-Type: text/plain');
          break;
        
        default:
          show_error('what the ..');
          break;
      }

      echo $news[ $type ]; die();
    }
    else
    {
      show_error('news_id not found');
    }
  }

  public function upload()
  {
    $local_data = array();
    $local_data['page_title'] = $this->data['page_title'] = 'Newsletter';
    
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

    if ( ! $this->upload->do_upload('newsletter_image'))
    {
      $local_data['error'] = array('newsletter_image' => $this->upload->display_errors());
    }
    else
    {
      // file uploaded to /tmp
      $upload_data = $this->upload->data();

      // upload file to s3
      $this->load->config('api_key', TRUE);
      $bucket = $this->config->item('s3_bucket', 'api_key');

      $s3_key = 'email/'.$upload_data['file_name'];
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

      $local_data['upload_data'] = $upload_data;
      $local_data['result'] = $result;
      $local_data['s3_object_url'] = $s3_object_url;
    }

    $this->data['main_content'] = $this->load->view('tool/newsletter_upload', $local_data, TRUE);
    $this->data['main_content'] = $this->load->view('tool/base', $this->data, TRUE);
    $this->load->view('base', $this->data);
  }
}
