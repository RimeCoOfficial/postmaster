<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| AWS SDK
|
| http://aws.amazon.com/sdk-for-php/
|--------------------------------------------------------------------------
*/

$config = [
    'navbar' => [
    'stats'             => 'Stats',
    'list-unsubscribe'  => 'List-unsubscribe',
    'message'           => 'Message',
    's3'                => 'S3',
    'settings'          => 'Settings',
  ],
  'nav_tab' => [
    's3' => [
      'upload'  => 'Upload',
      'object'  => 'Objects',
    ],
    'stats' => [
      'index' => 'Feedback',
      'history' => 'History',
    ],
    // 'campaign' => [
    //   'message' => 'Messages',
    //   'history' => 'History',
    // ],
    // 'transactional' => [
    //   'message' => 'Messages',
    //   'history' => 'History',
    // ]
  ],
];
