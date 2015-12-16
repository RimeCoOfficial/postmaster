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

    <a href="https://github.com/RimeOfficial/postmaster"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/52760788cde945287fbb584134c4cbc2bc36f904/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f77686974655f6666666666662e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_white_ffffff.png"></a>
    
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
                <?php
                if ($is_logged_in)
                {
                  $nav_list = $navbar['left'];
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
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span></a>
                      <ul class="dropdown-menu">
                        <?php $nav_list = $navbar['right']; ?>
                        <?php foreach ($nav_list as $uri => $name): ?>
                          <li>
                            <a href="<?php echo base_url($uri); ?>"><?php echo $name; ?></a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </li>
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

          <footer class="text-muted">
            <hr>
            
            <p>
              

              <span class="pull-right">
                <a href="https://rime.co/about" class="text-muted" target="_blank"><small>Made In India</small></a> 🇮🇳 
              </span>
            </p>

            <!-- <div class="clearfix"></div> -->

            <dl>
              <span class="glyphicon glyphicon-barcode"></span>
              <dt class="small pull-right">
                v1.0
              </dt>
              <dd>Page rendered in <strong>{elapsed_time}</strong> seconds</dd>
              <dd>CodeIgniter Version <strong><?php echo CI_VERSION; ?></strong></dd>
            </dl>

          </footer>
        </div>
      </div>
    </div>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </body>
</html>
