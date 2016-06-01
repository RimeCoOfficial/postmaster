<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Aws\S3\S3Client;
use GuzzleHttp\Promise;
use Aws\Exception\AwsException;

class Lib_s3_object
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();

    $this->CI->load->config('api_key', TRUE);
    $config = $this->CI->config->item('aws', 'api_key');
    $this->bucket = $config['s3_bucket'];

    $this->CI->load->library('composer/lib_aws');
    $this->s3_client = $this->CI->lib_aws->get_s3();
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

    $result = $this->s3_client->listObjects(array('Bucket' => $this->bucket, 'Delimiter' => '/', 'Prefix' => $prefix));
    return $result->toArray();
  }

  function upload($upload, $prefix = '')
  {
    $tmp_full_path = $upload['full_path'];

    // upload file to s3
    $key = '';
    if (!empty($prefix)) $key = $prefix.'/';
    $key .= date('Ymd-Hms', time()).'_'.$upload['file_name'];

    $result = $this->s3_client->putObject(array(
      'Bucket'     => $this->bucket,
      'Key'        => $key,
      'SourceFile' => $tmp_full_path,
    ));

    // We can poll the object until it is accessible
    $this->s3_client->waitUntil('ObjectExists', array(
      'Bucket' => $this->bucket,
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

  function upload_async($objects = [])
  {
    if (empty($objects))
    {
      $this->error = ['message' => 'object array is empty'];
      return NULL;
    }

    $promises = [];
    foreach ($objects as $id => $object) {
      // $key = 'data.txt', $body = 'Hello!'
      // Executing an operation asynchronously returns a Promise object.
      $promises[ $id ] = $this->s3_client->putObjectAsync([
        'Bucket'      => $this->bucket,
        'Key'         => $object['key'],
        'Body'        => $object['body'],
        'ContentType' => $object['content-type'],
      ]);
    }

    // Wait for the operation to complete to get the Result object.
    try {
      $results = Promise\unwrap($promises);
    } catch (AwsException $e) {
      // handle the error.
      $error_msg = 'getAwsRequestId: '.$e->getAwsRequestId().', getAwsErrorType:'.$e->getAwsErrorType().', getAwsErrorCode:'.$e->getAwsErrorCode()."\n\n";
      $error_msg .= $e->getMessage()."\n";
      $error_msg .= $e->getTraceAsString();
    }

    // if (!empty($this->error)) echo $error_msg['message']; else var_dump($results); die();

    if (!empty($error_msg))
    {
      $this->error = ['message' => $error_msg];
      return NULL;
    }

    $response = [];
    foreach ($results as $id => $result) {
      if (!empty($result['ObjectURL'])) $response[ $id ] = $result['ObjectURL'];
    }

    return $response;
  }
}