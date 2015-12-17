<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!-- 
Fork: https://github.com/RimeOfficial/postmaster
Wiki: https://github.com/RimeOfficial/postmaster/wiki

Page rendered in {elapsed_time} seconds
CodeIgniter Version <?php echo CI_VERSION; ?> 
 -->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Postmaster</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
    <style type="text/css">
      body { padding-top: 20px; padding-bottom: 20px; }
      .container { max-width: 680px; }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
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
                <?php
                if (!$is_logged_in)
                {
                  ?>
                  <a class="navbar-brand">Postmaster</a>
                  <?php
                }
                else
                {
                  ?>
                  <a class="navbar-brand visible-xs-inline">Postmaster</a>
                  <?php
                }
                ?>
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <?php
                if ($is_logged_in)
                {
                  $nav_selected = explode('/', uri_string());
                  $nav_selected = $nav_selected[0];
                  ?>
                  <ul class="nav navbar-nav">
                    <?php foreach ($navbar as $uri => $name): ?>
                    <li class="<?php if ($nav_selected == $uri) echo 'active'; ?>">
                      <a href="<?php echo base_url($uri); ?>"><?php echo $name; ?></a>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                  <?php
                }
                ?>
                
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

          <hr>
          <footer>

            <p class="small">
              <a class="text-muted" href="https://github.com/RimeOfficial/postmaster">
                <span class="glyphicon glyphicon-barcode"></span>
                <strong class="pull-right">Postmaster v1.0</strong>
              </a>
            </p>

          </footer>
        </div>
      </div>
    </div>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </body>
</html>
