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
$message_owner_options      = ['autoresponder' => 'Autoresponder', 'campaign' => 'Campaign', 'transactional' => 'Transactional'];

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

  'list_id' => array(
    'label'         => 'List-unsubscribe ID',
    'rules'         => 'trim|is_natural_no_zero|greater_than[0]|required',

    'max_length'    => $reply_to_name_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'List-unsubscribe id without the hash (eg. 1 for list-unsubscribe: test #1)',
    'required'      => 1,
  ),

  'owner' => array(
    'label'         => 'Genre',
    'rules'         => 'trim|in_list['.implode(',', array_keys($message_owner_options)).']|required',

    'options'       => $message_owner_options,
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

  // 'message_owner'  => array(
  //   'label'         => 'Owner',
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