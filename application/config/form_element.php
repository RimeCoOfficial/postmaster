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

$email_max_length           =  256;

$date_picker_length         =   19; // 'YYYY-MM-DD HH:MM AM'

$news_title_max_length      =   75;
$news_desc_max_length       = 4000;

$reply_to_name_max_length   = 128;

$category_max_length        =  64;
$subject_max_length         = 128;

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
  // newsletter
  'newsletter_title' => array(
    'label'         => 'Title',
    'rules'         => 'max_length['.$news_title_max_length.']|htmlspecialchars|trim|required',

    'max_length'    => $news_title_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'Enter something really interesting.',
  ),
  'newsletter_description' => array(
    'label'         => 'Description',
    'rules'         => 'max_length['.$news_desc_max_length.']|trim|required',

    'rows'          => 20,
    'max_length'    => $news_desc_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'Tell something about this letter in '.$news_desc_max_length.' characters',
    'required'      => 1,
  ),
  'newsletter_image' => array(
    'label'         => 'Select image to upload',
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'type'          => 'file',
  ),

  'category' => array(
    'label'         => 'Category',
    'rules'         => 'strtolower|max_length['.$category_max_length.']|trim|alpha_dash|required',

    'max_length'    => $category_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'Don\'t worry, you can change it later.',
    'required'      => 1,
  ),

  'subject' => array(
    'label'         => 'Subject',
    'rules'         => 'max_length['.$subject_max_length.']|trim|required',

    'max_length'    => $subject_max_length,
    
    // html5 tag - not supported in Internet Explorer 9 and earlier versions.
    'placeholder'   => 'Don\'t worry, you can change it later.',
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