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

$config = [
    'attachments' => [
        'title' => 'Pictures inline or Files',
        'icon' => 'glyphicon-picture',

        'upload'  => [
            'upload_path'       => '/tmp/',
            'allowed_types'     => 'gif|jpg|png|md|txt',
            'max_filename'      => 200, // type_name / [YYYYmmdd-HHmmss_filename.ext]
            'file_ext_tolower'  => TRUE,
            'overwrite'         => TRUE,
            'max_size'          => '2048',
            'max_width'         => '750',
            'max_height'        => '750',
            // 'encrypt_name'      => FALSE, 
            'remove_spaces'     => TRUE,
        ]
    ],
    'contacts' => [
        'title' => 'Import contact list',
        'icon' => 'glyphicon-list',

        'upload'  => [
            'upload_path'       => '/tmp/',
            'allowed_types'     => 'csv|xls',
            'max_filename'      => 200,
            'file_ext_tolower'  => TRUE,
            'overwrite'         => TRUE,
            'max_size'          => '2048',
            // 'encrypt_name'      => FALSE, 
            'remove_spaces'     => TRUE,
        ],
    ],
    // 'archive', 'log'
];
