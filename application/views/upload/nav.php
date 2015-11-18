<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
$nav_list = [
  '' => 'Upload',
  'go' => 'Go',
];

$nav_selected = explode('/', uri_string());
$nav_selected = !empty($nav_selected[1]) ? $nav_selected[1] : '';
?>

<ul class="nav nav-pills">
  <?php foreach ($nav_list as $uri => $name): ?>
  <li class="<?php if ($nav_selected == $uri) echo 'active'; ?>">
    <a href="<?php echo base_url('upload/'.$uri); ?>"><?php echo $name; ?></a>
  </li>
  <?php endforeach; ?>
</ul>
