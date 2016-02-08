<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!-- 
Fork: https://github.com/RimeOfficial/postmaster
Wiki: https://github.com/RimeOfficial/postmaster/wiki

Page rendered in {elapsed_time} seconds
CodeIgniter Version <?php echo CI_VERSION; ?> 
PHP version <?php echo phpversion(); ?> 
 -->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title><?php echo app_name(); ?> - AWS email server</title>
    <meta name="title" content="<?php echo app_name(); ?> - AWS email server">
    <meta name="description" content="🍳 Fork: https://github.com/RimeOfficial/postmaster 🍺 Wiki: https://github.com/RimeOfficial/postmaster/wiki">

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
      body { padding-top: 20px; padding-bottom: 20px; }
      .container { max-width: 680px; }
    </style>
  </head>
  <body>
   
    <div class="container">
      <div class="row">
        <div class="col-xs-12">

          <?php echo $main_content; ?>

          <hr>
          <footer>

            <p class="small">
              <iframe src="https://ghbtns.com/github-btn.html?user=RimeOfficial&repo=postmaster&type=fork&count=true" frameborder="0" scrolling="0" width="130px" height="20px"></iframe>

              <a class="text-muted" href="http://pages.rime.co/postmaster">
                <img class="img-responsive pull-right" src="<?php echo base_url('gh-pages/images/apache2.svg'); ?>">
              </a>
            </p>

          </footer>
        </div>
      </div>
    </div>
  </body>
</html>
