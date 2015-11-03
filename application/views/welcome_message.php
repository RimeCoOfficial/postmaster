<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!-- 
Page rendered in {elapsed_time} seconds.
CodeIgniter Version CI_VERSION
 -->
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link href="https://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Welcome to CodeIgniter!</h1>
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