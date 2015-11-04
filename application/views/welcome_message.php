<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!-- 
Page rendered in {elapsed_time} seconds, Memory used {memory_usage}
<?php echo 'CodeIgniter Version ' . CI_VERSION; ?>.
 -->
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Postmaster</title>
	<link href="https://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <!-- <li role="presentation" class="active"><a href="#">Home</a></li> -->
            <?php
            if ($is_logged_in)
            {
              ?>
              <li role="presentation"><a href="<?php echo base_url('auth/sign-out') ?>">Sign out</a></li>
              <?php
            }
            else
            {
              ?>
              <li role="presentation" class="active"><a href="<?php echo base_url('auth/sign-in') ?>">Sign in</a></li>
              <?php
            }
            ?>
          </ul>
        </nav>
        <h3 class="text-muted">Postmaster</h3>
      </div>

      <h1>Welcome!</h1>
  		<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

  		<p>If you would like to edit this page you'll find it located at:</p>
  		<code>application/views/welcome_message.php</code>

  		<p>The corresponding controller for this page is found at:</p>
  		<code>application/controllers/Welcome.php</code>

  		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>

      <footer class="footer">
        <p>Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
      </footer>
    </div>
	</div>
</div>

</body>
</html>