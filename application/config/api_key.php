<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| AWS SDK
|
| http://aws.amazon.com/sdk-for-php/
|--------------------------------------------------------------------------
*/
$config['aws']['account_id'] = getenv('aws_account_id');
$config['aws']['access_key'] = getenv('aws_access_key');
$config['aws']['secret_key'] = getenv('aws_secret_key');
$config['aws']['region']     = getenv('aws_region');
$config['aws']['s3_bucket']  = getenv('aws_s3_bucket');
