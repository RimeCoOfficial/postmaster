<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!-- 
Page rendered in {elapsed_time} seconds, Memory used {memory_usage}
<?php echo 'CodeIgniter Version ' . CI_VERSION; ?>.
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
            <nav class="navbar navbar-default">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>">Postmaster</a>
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <?php
                if ($is_logged_in)
                {
                  $nav_list = [
                    'stats'       => '<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>',
                    'campaign'    => 'Campaign',
                    'transaction' => 'Transaction',
                    's3-object'   => '<span class="glyphicon glyphicon-open-file" aria-hidden="true"></span>',
                    'settings'    => '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>',
                  ];
                  $nav_selected = explode('/', uri_string());
                  $nav_selected = $nav_selected[0];
                  ?>
                  <ul class="nav navbar-nav">
                    <?php foreach ($nav_list as $uri => $name): ?>
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

          <?php $this->view('alert'); ?>

          <?php echo $main_content; ?>

          <footer>
            <hr>
            <p>Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
          </footer>
        </div>
      </div>
    </div>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </body>
</html>