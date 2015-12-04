<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
$nav = [
  'nav_list' => [
    'message' => 'Messages',
    'label' => 'Labels',
    'history' => 'History',
  ],
  'nav_base_uri' => 'transaction',
];

$this->view('nav_tab', $nav);
?>