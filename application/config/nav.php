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
    'stats'         => '<span class="glyphicon glyphicon-stats"></span>',
    'message'       => '<span class="glyphicon glyphicon-envelope"></span>',
    's3'            => '<span class="glyphicon glyphicon-open-file"></span>',
    'autoresponder' => 'Autoresponder',
    'campaign'      => 'Campaign',
    'transactional' => 'Transactional',
    'settings'      => '<span class="glyphicon glyphicon-cog"></span>',
  ],
  'nav_tab' => [
    's3' => [
      'upload'  => 'Upload',
      'object'   => 'Objects',
    ],
    'autoresponder' => [
      'message' => 'Messages',
      'lists'   => 'Lists',
      'history' => 'History',
    ],
    'campaign' => [
      'message' => 'Messages',
      'lists'   => 'Lists',
      'history' => 'History',
    ],
    'transactional' => [
      'message' => 'Messages',
      'label'   => 'Labels',
      'history' => 'History',
    ]
  ],
];
