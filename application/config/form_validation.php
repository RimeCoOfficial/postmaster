<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Form Validation Settings
| -------------------------------------------------------------------------
|
*/

$config = array(
  // 'controller/method'           => ['value1', 'value2'],
  'auth/sign_in'                => ['email'],
  'list_unsubscribe/create'     => ['list', 'type'],
  'list_unsubscribe/edit'       => ['list'],

  'message/create'              => ['subject'],
  'message/edit'                => ['subject', 'reply_to_name', 'reply_to_email', 'body_html_input'],
  'message/publish'             => ['php_datetime_str'],
  'message/send_test'           => ['email'],

  'open/subscribe'              => ['full_name', 'email'],
);

if ( ! function_exists('fill_element'))
{
  function fill_element($config)
  {
    $CI =& get_instance();
    $CI->config->load('form_element', TRUE);

    foreach ($config as $path => $elem_arr) foreach ($elem_arr as $key => $id)
    {
      $element = $CI->config->item($id, 'form_element');
      $element = array(
        'field' => $id,
        'label' => $element['label'],
        'rules' => $element['rules'],
      );

      $config[ $path ][ $key ] = $element;
    }

    return $config;
  }
}

$config = fill_element($config);
// var_dump($config); // die();