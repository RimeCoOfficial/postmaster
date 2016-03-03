<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- <h1>Welcome!</h1> -->

<div class="jumbotron">
  <h1>Hello, world!</h1>
  <p>This is a email server powered by AWS.</p>
  <p><a class="btn btn-primary btn-lg" href="http://www.rime.co/postmaster" role="button">Learn more</a></p>

  <p><strong>Got something to report</strong>, <?php echo mailto(getenv('email_admin'), 'contact this human'); ?>!</p>
</div>