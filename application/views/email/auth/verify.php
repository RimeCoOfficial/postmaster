<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php echo anchor('auth/verify/'.$login_email_key, NULL, 'target="_blank"'); ?>

Happy emailing!
&mdash; The <?php echo app_name(); ?>
