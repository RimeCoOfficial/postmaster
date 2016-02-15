<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
if (ENVIRONMENT === 'development')
{
  ?>
  <h1><samp><strong>CI_ENV</strong>=<span class="text-danger"><?php echo ENVIRONMENT; ?></span></samp></h1>
  <p><?php echo anchor('auth/verify/'.$login_email_key); ?></p>
  <?php
}
else
{
  ?>
  <h1>Check your <abbr title="<?php echo getenv('email_admin'); ?>">email</abbr> to login</h1>
  <p>The email link expires in 15 mins. So hurry!</p>
  <?php
}
?>

<br>