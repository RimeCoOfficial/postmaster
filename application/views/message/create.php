<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>New Message</h1>

<p class="lead">
  #
  
  List-unsubscribe: <?php echo $list_unsubscribe['list']; ?>

  <span class="pull-right">
    <span class="label label-default"><?php echo $list_unsubscribe['type']; ?></span>
  </span>
</p>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'subject', 'value' => NULL)); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Create</button>
  </div>
</div>

<?php echo form_close(); ?>

<br>