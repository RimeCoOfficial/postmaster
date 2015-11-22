<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_s3_object
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    // $this->CI->load->model('model_aws_cache');
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
    // return $this->CI->model_aws_cache->get('s3', 'listObjects');

    $this->CI->load->library('composer/lib_aws');
    $s3_client = $this->CI->lib_aws->get_s3();

    $this->CI->load->config('api_key', TRUE);
    $config = $this->CI->config->item('aws', 'api_key');
    $bucket = $config['s3_bucket'];

    $result = $s3_client->listObjects(array('Bucket' => $bucket));

    // $this->CI->load->model('model_aws_cache');
    // $this->CI->model_aws_cache->store($service, $method, $result);

    return $result;
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

    $key = '';
    if (!empty($type)) $key = $type.'/';
    $key .= date('Ymd-Hms', time()).'_'.$upload['file_name'];

    $result = $s3_client->putObject(array(
      'Bucket'     => $bucket,
      'Key'        => $key,
      'SourceFile' => $tmp_full_path,
    ));

    // We can poll the object until it is accessible
    $s3_client->waitUntil('ObjectExists', array(
      'Bucket' => $bucket,
      'Key'    => $key
    ));

    // clean up
    unlink($tmp_full_path);

    if (empty($result['ObjectURL']))
    {
      $this->error = ['message' => 'ObjectURL not found in AWS response'];
      return NULL;
    }

    // $this->CI->model_aws_cache->update('s3', 'listObjects');

    $s3_object_url = $result['ObjectURL'];
    return $s3_object_url;
  }

  function delete($key)
  {
    $this->CI->load->config('api_key', TRUE);
    $config = $this->CI->config->item('aws', 'api_key');
    $bucket = $config['s3_bucket'];

    $this->CI->load->library('composer/lib_aws');
    $s3_client = $this->CI->lib_aws->get_s3();

    $result = $s3_client->deleteObject(array(
      'Bucket'     => $bucket,
      'Key'        => $key
    ));

    // $this->CI->model_aws_cache->update('s3', 'listObjects');

    return TRUE;
  }

  function archive($key)
  {
    $this->CI->load->config('api_key', TRUE);
    $config = $this->CI->config->item('aws', 'api_key');
    $bucket = $config['s3_bucket'];

    $this->CI->load->library('composer/lib_aws');
    $s3_client = $this->CI->lib_aws->get_s3();

    $archived_key = '_archived'.'/';
    if (starts_with($key, $archived_key)) $target_keyname = substr($key, strlen($archived_key)) ;
    else                                  $target_keyname = $archived_key.$key;

    $source_bucket = $bucket;
    $source_keyname = $key;
    $target_bucket = $bucket;
    $target_keyname = $target_keyname;

    // Copy an object.
    $s3_client->copyObject(array(
      'Bucket'     => $target_bucket,
      'Key'        => $target_keyname,
      'CopySource' => "{$source_bucket}/{$source_keyname}",
    ));

    $s3_client->deleteObject(array(
      'Bucket'     => $source_bucket,
      'Key'        => $source_keyname
    ));

    // $this->CI->model_aws_cache->update('s3', 'listObjects');

    return TRUE;
  }
}