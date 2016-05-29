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
              Project maintained by <strong><?php echo anchor('http://github.com/rimeofficial', 'rimeofficial', 'target="_blank"'); ?></strong>

              <span class="pull-right">
                <strong>GitHub</strong>
                <?php echo anchor('http://github.com/rimeofficial/postmaster/wiki', 'Wiki', 'target="_blank"'); ?>
                <?php echo anchor('http://github.com/rimeofficial/postmaster/issues', 'Report an issue', 'target="_blank"'); ?>
              </span>
            </p>
          </footer>
        </div>
      </div>
    </div>

    <?php $this->view('footer'); ?>
  </body>
</html>
