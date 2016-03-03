<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
| http://codeigniter.com/user_guide/libraries/email.html
|
*/
$config['useragent']  = 'Postmaster';

$config['protocol']   = 'smtp';
$config['smtp_host']  = 'ssl://email-smtp.us-east-1.amazonaws.com';
$config['smtp_port']  = 465;
$config['smtp_user']  = getenv('ci_email_smtp_user');
$config['smtp_pass']  = getenv('ci_email_smtp_pass');

$config['mailtype']   = 'html';
$config['charset']    = 'utf-8';
$config['newline']    = "\r\n";
$config['crlf']       = "\n";