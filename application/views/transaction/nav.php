<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
$nav_list = [
  'message' => 'Messages',
  'label' => 'Labels',
  'history' => 'History',
];

$nav_selected = explode('/', uri_string());
$nav_selected = !empty($nav_selected[1]) ? $nav_selected[1] : 'home';
?>

<ul class="nav nav-tabs">
  <?php foreach ($nav_list as $uri => $name): ?>
  <li class="<?php if ($nav_selected == $uri) echo 'active'; ?>">
    <a href="<?php echo base_url('transaction/'.$uri); ?>"><?php echo $name; ?></a>
  </li>
  <?php endforeach; ?>
</ul>
