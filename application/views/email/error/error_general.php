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
  <strong>Heading:</strong> <?php echo $heading; ?><br>
  <strong>Message:</strong> <?php echo $message; ?><br>
  <strong>Status Code:</strong> <?php echo $status_code; ?><br>
</p>

<?php $this->view('email/error/backtrace'); ?>

<br>

<p>
  Happy debugging!<br>
  &mdash; The <?php echo app_name(); ?> Bot (<?php echo e_anchor('@bot', '@bot'); ?>)
</p>
