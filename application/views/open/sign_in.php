<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
if (!empty($login_email_key) AND ENVIRONMENT !== 'production')
{
  ?>
  <h1><samp><strong>CI_ENV</strong>=<span class="text-danger"><?php echo ENVIRONMENT; ?></span></samp></h1>
  <p><?php echo anchor('auth/verify/'.$login_email_key); ?></p>
  <?php
}
elseif (!empty($email_webmaster))
{
  ?>
  <h1>Check your <abbr title="<?php echo $email_webmaster; ?>">email</abbr> to login</h1>
  <p>The email link expires in 15 mins. So hurry!</p>
  <?php
}
else
{
  ?>
  <h1>Sign in</h1>

  <?php echo form_open(uri_string()); ?>

  <?php $this->view('form/input', array('id' => 'email', 'value' => NULL)); ?>

  <div class="row">
    <div class="col-sm-5">
      <button type="submit" class="btn btn-primary btn-block">
        Submit
      </button>
    </div>
  </div>

  <?php echo form_close(); ?>

  <br>
  <p>
    <strong>Not able to sign-in?</strong> Click <strong><?php echo mailto(getenv('email_admin'), 'here'); ?></strong> to contact admin.
  </p>
  <?php
}
?>