<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<p>
  <?php echo anchor('auth/verify/'.$login_email_key, NULL, 'target="_blank"'); ?>
</p>

<p>
  Happy emailing!<br>
  &mdash; The <?php echo app_name(); ?>
</p>
