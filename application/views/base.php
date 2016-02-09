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

          <header>
            <?php
            $this->load->config('nav', TRUE);
            $navbar = $this->config->item('navbar', 'nav');
            ?>
            <nav class="navbar navbar-default">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                
                <a class="navbar-brand">Postmaster</a>
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                  
                  <?php
                  if ($is_logged_in)
                  {
                    $nav_selected = explode('/', uri_string());
                    $nav_selected = $nav_selected[0];
                    
                    foreach ($navbar as $uri => $name): ?>
                      <li class="<?php if ($nav_selected == $uri) echo 'active'; ?>">
                        <a href="<?php echo base_url($uri); ?>"><?php echo $name; ?></a>
                      </li>
                    <?php endforeach;
                  }
                  ?>
                  <!-- <li>
                    <a href="https://github.com/Rimeofficial/postmaster" title="Fork me on GitHub" target="_blank">
                      <span class="glyphicon glyphicon-cutlery"></span>
                    </a>
                  </li> -->
                </ul>
                
                <ul class="nav navbar-nav navbar-right">
                  <?php
                  if ($is_logged_in)
                  {
                    ?>
                    <li><a href="<?php echo base_url('auth/sign-out') ?>">Sign out</a></li>
                    <?php
                  }
                  else
                  {
                    ?>
                    <li><a href="<?php echo base_url('auth/sign-in') ?>">Sign in</a></li>
                    <?php
                  }
                  ?>
                </ul>
              </div>
            </nav>
          </header>

          <?php $this->view('nav_tab'); ?>
          <?php $this->view('alert'); ?>

          <?php echo $main_content; ?>

          <!-- <hr> -->
          <footer>

            <p class="small">
              <a href="https://GitHub.com/RimeOfficial/postmaster">
                <img class="img-responsive pull-left" src="<?php echo asset_url('images/GitHub-Mark-20px.png'); ?>" width="20px">
              </a>

              <a href="http://pages.rime.co/postmaster">
                <img class="img-responsive pull-right" src="<?php echo asset_url('images/license-apache2.svg'); ?>">
              </a>
            </p>

          </footer>
        </div>
      </div>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>
