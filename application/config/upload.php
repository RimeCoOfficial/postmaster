<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['upload_path']      = '/tmp';
$config['allowed_types']    = 'gif|jpg|png';
$config['file_name']        = date('Ymd-Hms', time());
$config['file_ext_tolower'] = TRUE;
$config['overwrite']        = TRUE;
$config['max_size']         = '2048';
$config['max_width']        = '750';
$config['max_height']       = '750';

// $config['encrypt_name']     = FALSE;  // DEFAULT
// $config['remove_spaces']    = TRUE;   // DEFAULT
// $config['detect_mime']      = TRUE;   // DEFAULT
// $config['mod_mime_fix']     = TRUE;   // DEFAULT
