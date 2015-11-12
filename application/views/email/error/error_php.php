<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<code>
  <strong>Severity:</strong> <?php echo $severity; ?><br>
  <strong>Message:</strong> <?php echo $message; ?><br>
  <strong>Filename:</strong> <?php echo $filepath; ?><br>
  <strong>Line:</strong> <?php echo $line; ?><br>
</code>

<?php
if (!empty($ip))
{
  ?>
  <code>
    <strong>IP:</strong> <?php echo $ip; ?>
  </code>
  <br>
  <?php
}
?>

<?php $this->view('email/error/backtrace'); ?>

<br>

<p>
  Happy debugging!<br>
  &mdash; The <?php echo app_name(); ?>
</p>
