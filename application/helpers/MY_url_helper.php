<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function s3_base_url($str = '')
{
  $CI =& get_instance();
  $CI->load->config('api_key', TRUE);
  $config = $CI->config->item('aws', 'api_key');

  $aws_region = $config['region'];

  $url = 'https://';

  // US East (N. Virginia)        us-east-1
  // US West (Oregon)             us-west-2
  // US West (N. California)      us-west-1
  // EU (Ireland)                 eu-west-1
  // EU (Frankfurt)               eu-central-1
  // Asia Pacific (Singapore)     ap-southeast-1
  // Asia Pacific (Sydney)        ap-southeast-2
  // Asia Pacific (Tokyo)         ap-northeast-1
  // South America (Sao Paulo)    sa-east-1
  $url .= ($aws_region === 'us-east-1') ? 's3' : 's3-'.$aws_region;
  $url .= '.amazonaws.com';
  $url .= '/'.$config['s3_bucket'];

  if (!empty($str)) $url .= '/'.$str;

  return $url;
}

function asset_url($str='')
{
  return get_instance()->config->item('asset_url').$str;
}