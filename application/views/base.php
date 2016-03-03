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
    <?php $this->view('head'); ?>
  </head>
  <body>
   
    <div class="container">
      <div class="row">
        <div class="col-xs-12">

          <header>
            <?php $this->view('header'); ?>
          </header>

          <?php $this->view('nav_tab'); ?>
          <?php $this->view('alert'); ?>

          <?php echo $main_content; ?>

          <!-- <hr> -->
          <footer>

            <p class="small">
              <a href="https://GitHub.com/RimeOfficial/postmaster">
                <img class="img-responsive pull-left" src="<?php echo asset_url('images/Octicons-mark-github.svg'); ?>" width="20px">
              </a>

              <a href="http://www.rime.co/postmaster">
                <img class="img-responsive pull-right" src="<?php echo asset_url('images/license-apache-v2.svg'); ?>">
              </a>
            </p>
          </footer>
        </div>
      </div>
    </div>

    <?php $this->view('footer'); ?>
  </body>
</html>
