<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$navbar = $nav_tab = [
  'stats'             => 'Stats',
  'list-unsubscribe'  => 'List-unsubscribe',
  'message'           => 'Message',
  's3'                => 'S3',
  'settings'          => 'Settings',
];
?>
<nav class="navbar navbar-default">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
    </button>
    
    <a class="navbar-brand">Postmaster</a>
  </div>
  <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
      
      <?php
      if ($is_logged_in)
      {
        $nav_selected = explode('/', uri_string());
        $nav_selected = $nav_selected[0];
        
        foreach ($navbar as $uri => $name): ?>
          <li class="<?php if ($nav_selected == $uri) echo 'active'; ?>">
            <a href="<?php echo base_url($uri); ?>"><?php echo $name; ?></a>
          </li>
        <?php endforeach;
      }
      ?>
      <!-- <li>
        <a href="https://github.com/Rimeofficial/postmaster" title="Fork me on GitHub" target="_blank">
          <span class="glyphicon glyphicon-cutlery"></span>
        </a>
      </li> -->
    </ul>
    
    <ul class="nav navbar-nav navbar-right">
      <?php
      if ($is_logged_in)
      {
        ?>
        <li><a href="<?php echo base_url('auth/sign-out') ?>">Sign out</a></li>
        <?php
      }
      else
      {
        ?>
        <li><a href="<?php echo base_url('auth/sign-in') ?>">Sign in</a></li>
        <?php
      }
      ?>
    </ul>
  </div>
</nav>