<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Unsubscribed</h1>
<p class="lead">
  You have unsubscribed from <?php echo getenv('app_name') ?> emails.
  <!-- <a href="<?php echo getenv('app_base_url'); ?>" class="text-muted" target="_blank">
    <span class="glyphicon glyphicon-new-window"></span>
  </a> -->
</p>

<a href="<?php echo getenv('app_base_url'); ?>" class="btn btn-default text-muted">
  <!-- <span class="glyphicon glyphicon-new-window"></span> -->
  Continue to <?php echo getenv('app_name') ?> Home
</a>
