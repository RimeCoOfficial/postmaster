<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<code>
  <strong>Heading:</strong> <?php echo $heading; ?><br>
  <strong>Message:</strong> <?php echo $message; ?><br>
  <strong>Status Code:</strong> <?php echo $status_code; ?><br>
</code>
<br>

<?php
if (!empty($ip))
{
  ?>
  <code>
    <strong>IP:</strong> <?php echo $ip; ?>
    <strong>whoami:</strong> <?php echo $whoami; ?>
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
