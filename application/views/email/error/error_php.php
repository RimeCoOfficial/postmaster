<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
if (!empty($ip))
{
  ?>
  <p>
    <strong>IP:</strong> <?php echo $ip; ?>
  </p>
  <?php
}
?>

<p>
  <strong>Severity:</strong> <?php echo $severity; ?><br>
  <strong>Message:</strong> <?php echo $message; ?><br>
  <strong>Filename:</strong> <?php echo $filepath; ?><br>
  <strong>Line:</strong> <?php echo $line; ?><br>
</p>

<?php $this->view('email/error/backtrace'); ?>

<br>

<p>
  Happy debugging!<br>
  &mdash; The <?php echo app_name(); ?> Bot (<?php echo e_anchor('@bot', '@bot'); ?>)
</p>
