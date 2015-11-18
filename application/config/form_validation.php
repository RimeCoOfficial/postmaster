<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Form Validation Settings
| -------------------------------------------------------------------------
|
*/

$config = array(
  // 'controller/method'            => ['value1', 'value2'],

  'transaction/label/create'      => ['label'],
  'transaction/label/modify'      => ['label'],

  'transaction/home/create'       => ['message_id', 'label_id'],
  'transaction/home/modify'       => ['label_id'],

  'message/create'                => ['subject'],
  'message/modify'                => ['subject', 'reply_to_name', 'reply_to_email', 'message_html'],
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