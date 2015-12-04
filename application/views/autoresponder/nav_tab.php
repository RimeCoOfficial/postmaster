<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
$nav = [
  'nav_list' => [
    'message' => 'Messages',
    'list' => 'Lists',
    'history' => 'History',
  ],
  'nav_base_uri' => 'autoresponder',
];

$this->view('nav_tab', $nav);
?>