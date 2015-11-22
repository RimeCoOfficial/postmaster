<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* String Helpers Class
*
* Extends String Helpers
*
*/

function app_name()
{
  return get_instance()->config->item('app_name');
}

function starts_with($haystack, $needle)
{
  // search backwards starting from haystack length characters from the end
  return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

function ends_with($haystack, $needle)
{
  // search forward starting from end minus needle length characters
  return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}

function s3_key_name($key, $prefix = '')
{
  $name = $key;
  
  if ($name == $prefix AND !empty($name))
  {
    $name = trim($name, '/');

    $name_list = explode('/', $name);
    if (count($name)) $name = end($name_list);
  }
  else
  {
    if (starts_with($name, $prefix)) $name = substr($name, strlen($prefix));

    $name = trim($name, '/');
  }

  return $name;
}