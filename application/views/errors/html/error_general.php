<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style type="text/css">
      body { padding-top: 20px; padding-bottom: 20px; }
      .container { max-width: 680px; }
    </style>
  </head>
  <body>
  	<div class="container">
  		<h1><?php echo $heading; ?></h1>
  		<?php echo $message; ?>
  	</div>
  </body>
</html>