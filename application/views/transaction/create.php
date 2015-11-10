<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav'); ?>

<h1>New Transaction</h1>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'subject', 'value' => NULL)); ?>

<?php $this->view('form/dropdown', array('id' => 'category_id', 'value' => NULL)); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Create</button>
  </div>
</div>

<?php echo form_close(); ?>
