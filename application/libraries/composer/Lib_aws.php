<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_aws
{
  public function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->config('api_key', TRUE);
    $config = $this->CI->config->item('aws', 'api_key');
    
    // http://docs.aws.amazon.com/aws-sdk-php/v3/guide/index.html
    $this->aws_client = new Aws\Sdk([
        'version'  => 'latest',

        'region' => $config['region'],

        'credentials' => array(
          'key'     => $config['access_key'],
          'secret'  => $config['secret_key'],
        ),
        
        // 'S3' => [
        //   'region' => $config['region'],
        // ]
    ]);

    // $credentials = $this->aws_client->getCredentials();
    // $credentials->setAccessKeyId($access_key);
    // $credentials->setSecretKey($secret_key);
    // $credentials->setExpiration(null);
  }

  public function get_s3()  { return $this->aws_client->createS3();  }
  public function get_swf() { return $this->aws_client->createSWF(); }
  public function get_sqs() { return $this->aws_client->createSQS(); }
}