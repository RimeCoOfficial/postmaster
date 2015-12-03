<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Aws\S3\S3Client;

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

  function delete($key)
  {
    $result = $this->s3_client->deleteObject(array(
      'Bucket'     => $this->bucket,
      'Key'        => $key
    ));

    return TRUE;
  }

  function attach($url_list)
  {
    if (empty($url_list)) return [];

    $s3_upload_url = s3_base_url('upload');
    $s3_attachment_url = s3_base_url('attachment');

    $s3_upload_list = [];
    $s3_attachment_list = [];

    foreach ($url_list as $url)
    {
      if (starts_with($url, $s3_upload_url))
      {
        $key_id = substr($url, strlen($s3_upload_url));
        $s3_upload_list[ $key_id ] = FALSE; // $url;
      }
    }

    if (!empty($s3_upload_list))
    {
      $promises = [];
      foreach ($s3_upload_list as $key_id => $value)
      {
        echo 'Attachment - '.$s3_upload_url.$key_id.PHP_EOL;
        echo "\t".'1. check in folder [upload]'.PHP_EOL;

        $promise = $this->s3_client->getObjectAsync(array(
          'Bucket' => $this->bucket,
          'Key' => 'upload'.$key_id,
        ));

        $promise->then(
          function ($value) use ($key_id)
          {
            echo "\t".'2. copy file to attachment'.PHP_EOL;

            return $this->s3_client->copyObjectAsync(array(
              'Bucket' => $this->bucket,
              'Key' => 'attachment'.$key_id,
              'CopySource' => $this->bucket.'/upload'.$key_id,
            ));
          },
          function ($reason) use ($key_id)
          {
            echo "\t".'3. check attachment for the key'.PHP_EOL;

            if ($reason->getStatusCode() == 404)
            {
              return $this->s3_client->getObjectAsync(array(
                'Bucket' => $this->bucket,
                'Key' => 'attachment'.$key_id,
              ));
            }
          }
        )->then(
          function ($value) use (&$s3_upload_list, $key_id)
          {
            $s3_upload_list[ $key_id ] = TRUE;
            echo "\t".'Attachment successful: '.$key_id.PHP_EOL;
          },
          function ($reason) use (&$s3_upload_list, $key_id)
          {
            $s3_upload_list[ $key_id ] = FALSE;
            echo "\t".'Attachment failed: '.$key_id.PHP_EOL;
          }
        );

        $promises[] = $promise;
        break;
      }

      // Wait on promises to complete and return the results.
      try {
        $results = GuzzleHttp\Promise\unwrap($promises);
        // print_r($results); die();
      } catch (Aws\Exception\AwsException $e) {
        // print_r($e->getStatusCode());

        if ($e->isConnectionError())
        {
          $this->error = ['message' => 'Bam! connection error'];
          return NULL;
        }
      }
    }
    
    foreach ($s3_upload_list as $key_id => $value) if ($value)
    {
      $s3_attachment_list[ $s3_upload_url.$key_id ] = $s3_attachment_url.$key_id;
    }
    
    return $s3_attachment_list;
  }
}