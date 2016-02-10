<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
$nav_selected = explode('/', uri_string());
$nav_selected = $nav_selected[0];

$nav_tab = [
  's3' => [
    'upload'  => 'Upload',
    'object'  => 'Objects',
  ],
  'stats' => [
    'index' => 'Feedback',
    'history' => 'History',
  ]
];

// var_dump($nav_selected); die();
?>

<?php if (!empty($nav_tab[ $nav_selected ])): ?>
  <?php
  $nav_base_uri = $nav_selected;
  $nav_list     = $nav_tab[ $nav_selected ];

  // if (empty($nav_base_uri)) $nav_base_uri = '';
  // if (empty($nav_list))     $nav_list = [];

  $current_uri = explode('/', uri_string());

  $nav_selected = !empty($current_uri[0]) AND $current_uri[0] == $nav_base_uri;
  if ($nav_selected) $nav_selected = !empty($current_uri[1]) ? $current_uri[1] : 'index';
  ?>

  <?php if (!empty($nav_list)): ?>
    <ul class="nav nav-tabs nav-justified" style="margin-bottom: 20px;">
      <?php foreach ($nav_list as $uri => $name): ?>
      <li class="<?php if ($nav_selected == $uri) echo 'active'; ?>">
        <a href="<?php echo base_url($nav_base_uri.'/'.$uri); ?>"><?php echo $name; ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
<?php endif; ?>