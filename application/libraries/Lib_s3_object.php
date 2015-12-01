<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_s3_object
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
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

  function get_list($prefix = '')
  {
    if (!empty($prefix) AND !ends_with($prefix, '/')) $prefix .= '/';
    
    $this->CI->load->library('composer/lib_aws');
    $s3_client = $this->CI->lib_aws->get_s3();

    $this->CI->load->config('api_key', TRUE);
    $config = $this->CI->config->item('aws', 'api_key');
    $bucket = $config['s3_bucket'];

    $result = $s3_client->listObjects(array('Bucket' => $bucket, 'Delimiter' => '/', 'Prefix' => $prefix));
    return $result->toArray();
  }

  function upload($upload, $prefix = '')
  {
    $tmp_full_path = $upload['full_path'];

    $this->CI->load->library('composer/lib_aws');
    $s3_client = $this->CI->lib_aws->get_s3();

    // upload file to s3
    $this->CI->load->config('api_key', TRUE);
    $config = $this->CI->config->item('aws', 'api_key');
    $bucket = $config['s3_bucket'];

    $key = '';
    if (!empty($prefix)) $key = $prefix.'/';
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

    return TRUE;
  }
}