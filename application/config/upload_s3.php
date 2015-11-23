<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// $config['upload_path']      = '/tmp';
// $config['allowed_types']    = 'gif|jpg|png';
// // $config['file_name']        = date('Ymd-Hms', time()); // lib_s3_object
// $config['max_filename']     = 240; // YYYYmmdd-HHmmss_filename.ext = 256 - 16 = 240
// $config['file_ext_tolower'] = TRUE;
// $config['overwrite']        = TRUE;
// $config['max_size']         = '2048';
// $config['max_width']        = '750';
// $config['max_height']       = '750';

// // $config['encrypt_name']     = FALSE;  // DEFAULT
// // $config['remove_spaces']    = TRUE;   // DEFAULT
// // $config['detect_mime']      = TRUE;   // DEFAULT
// // $config['mod_mime_fix']     = TRUE;   // DEFAULT

$config['inline-image'] ['upload_path']       = '/tmp/ci/upload';
$config['inline-image'] ['allowed_types']     = 'gif|jpg|png';
$config['inline-image'] ['max_filename']      = 200; // type_name / [YYYYmmdd-HHmmss_filename.ext]
$config['inline-image'] ['file_ext_tolower']  = TRUE;
$config['inline-image'] ['overwrite']         = TRUE;
$config['inline-image'] ['max_size']          = '2048';
$config['inline-image'] ['max_width']         = '750';
$config['inline-image'] ['max_height']        = '750';

$config['file']         ['upload_path']       = '/tmp/ci/upload';
$config['file']         ['allowed_types']     = 'md|txt';
$config['file']         ['max_filename']      = 200;
$config['file']         ['file_ext_tolower']  = TRUE;
$config['file']         ['overwrite']         = TRUE;
$config['file']         ['max_size']          = '2048';

$config['import']       ['upload_path']       = '/tmp/ci/upload';
$config['import']       ['allowed_types']     = 'csv|xls';
$config['import']       ['max_filename']      = 200;
$config['import']       ['file_ext_tolower']  = TRUE;
$config['import']       ['overwrite']         = TRUE;
$config['import']       ['max_size']          = '2048';
