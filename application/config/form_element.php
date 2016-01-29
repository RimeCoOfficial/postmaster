<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Form Elements
| -------------------------------------------------------------------------
|
| input:     username, email, login, full_name, location
| textarea:  bio, comment, feedback
| password:  password, old_password, confirm_password
| checkbox:  remember
| dropdown:  time_zone
|
*/

$email_max_length           =   256;

$date_picker_length         =    19; // 'YYYY-MM-DD HH:MM AM'

$body_html_input_max_length = 99000;

$reply_to_name_max_length   =    64;

$list_max_length            =    32;
$message_type_options       = [
  'autoresponder' => 'Autoresponder',
  'campaign'      => 'Campaign',
  'transactional' => 'Transactional'
];

$subject_max_length         =   128;

$config = array(
  'email' => array(
    'label'         => 'Email',
    'rules'         => 'strtolower|max_length['.$email_max_length.']|valid_email|trim|required',
    'max_length'    => $email_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'Type an email address',
    'type'          => 'email',
    'required'      => 1,
  ),
  
  
  'upload_s3_object' => array(
    'label'         => 'Select file to upload',
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'type'          => 'file',
  ),

  'list' => array(
    'label'         => 'List-unsubscribe',
    'rules'         => 'strtolower|max_length['.$list_max_length.']|trim|alpha_dash|required',

    'max_length'    => $list_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'Don\'t worry, you can change it later.',
    'required'      => 1,
  ),

  'type' => array(
    'label'         => 'Type',
    'rules'         => 'trim|in_list['.implode(',', array_keys($message_type_options)).']|required',

    'options'       => $message_type_options,
    'required'      => 1,
  ),

  'subject' => array(
    'label'         => 'Subject',
    'rules'         => 'max_length['.$subject_max_length.']|trim|required',

    'max_length'    => $subject_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'Enter something really interesting.',
    'required'      => 1,
  ),

  // 'message_type'  => array(
  //   'label'         => 'type',
  //   'rules'         => 'in_list[autoresponder,campaign,transactional]|required',

  //   'options'       => ['autoresponder' => 'Autoresponder', 'campaign' => 'Campaign', 'transactional' => 'Transactional'],
  //   'required'      => 1,
  // ),

  'body_html_input' => array(
    'label'         => 'Message',
    'rules'         => 'max_length['.$body_html_input_max_length.']|trim|required',

    'rows'          => 7,
    'max_length'    => $body_html_input_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'Tell something about this mail in HTML ('.$body_html_input_max_length.' characters)',
    'required'      => 1,
  ),

  'php_datetime_str' => array(
    'label'         => 'PHP datetime',
    'rules'         => 'max_length[24]|trim|required', // '1000-01-01 00:00:00'[19]
    'max_length'    => $email_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'A date/time string.',
    'help'          => 'A date/time string. Valid formats are explained in <a href="http://php.net/manual/en/datetime.formats.php" target="_blank">Date and Time Formats</a>.',
    'required'      => 1,
  ),

  'reply_to_name' => array(
    'label'         => 'Reply-to Name',
    'rules'         => 'max_length['.$reply_to_name_max_length.']|trim',

    'max_length'    => $reply_to_name_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'Enter reply-to name, so people you know can recognize you.',
  ),
  'reply_to_email' => array(
    'label'         => 'Reply-to Email',
    'rules'         => 'strtolower|max_length['.$email_max_length.']|valid_email|trim',
    'max_length'    => $email_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'Type an email address',
    'type'          => 'email',
  ),
);