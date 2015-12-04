<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
if (empty($nav_base_uri)) $nav_base_uri = '';
if (empty($nav_list)) $nav_list = [];

$current_uri = explode('/', uri_string());

$nav_selected = !empty($current_uri[0]) AND $current_uri[0] == $nav_base_uri;
if ($nav_selected) $nav_selected = !empty($current_uri[1]) ? $current_uri[1] : 'home';
?>

<?php if (!empty($nav_list)): ?>
  <ul class="nav nav-tabs">
    <?php foreach ($nav_list as $uri => $name): ?>
    <li class="<?php if ($nav_selected == $uri) echo 'active'; ?>">
      <a href="<?php echo base_url($nav_base_uri.'/'.$uri); ?>"><?php echo $name; ?></a>
    </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>