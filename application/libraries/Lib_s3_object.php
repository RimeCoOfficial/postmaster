<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_s3_object
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_s3_object');
  }
  
  /**
   * Get error message.
   * Can be invoked after any failed operation.
   *
   * @return  string
   */
  function get_error_message()
  {
    return $this->error;
  }

  function get_list()
  {
    return $this->CI->model_s3_object->get_list();
  }

  function upload($upload, $type = NULL)
  {
    $tmp_full_path = $upload['full_path'];

    $this->CI->load->library('composer/lib_aws');
    $s3_client = $this->CI->lib_aws->get_s3();

    // upload file to s3
    $this->CI->load->config('api_key', TRUE);
    $config = $this->CI->config->item('aws', 'api_key');
    $bucket = $config['s3_bucket'];

    $s3_key = '';
    if (!empty($type)) $s3_key = $type.'/';
    $s3_key .= date('Ymd-Hms', time()).'_'.$upload['file_name'];

    $result = $s3_client->putObject(array(
      'Bucket'     => $bucket,
      'Key'        => $s3_key,
      'SourceFile' => $tmp_full_path,
    ));

    // We can poll the object until it is accessible
    $s3_client->waitUntil('ObjectExists', array(
      'Bucket' => $bucket,
      'Key'    => $s3_key
    ));

    // clean up
    unlink($tmp_full_path);

    if (empty($result['ObjectURL']))
    {
      $this->error = ['message' => 'ObjectURL not found in AWS response'];
      return NULL;
    }

    $this->CI->model_s3_object->store($s3_key, $upload['file_type'], $upload['file_size'], $upload['is_image']);

    $s3_object_url = $result['ObjectURL'];
    return $s3_object_url;
  }

  function delete($s3_key)
  {
    $this->CI->load->config('api_key', TRUE);
    $config = $this->CI->config->item('aws', 'api_key');
    $bucket = $config['s3_bucket'];

    $this->CI->load->library('composer/lib_aws');
    $s3_client = $this->CI->lib_aws->get_s3();

    $result = $s3_client->deleteObject(array(
      'Bucket'     => $bucket,
      'Key'        => $s3_key
    ));

    $this->CI->model_s3_object->delete($s3_key);

    return TRUE;
  }
}