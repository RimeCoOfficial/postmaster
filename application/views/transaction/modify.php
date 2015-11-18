<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav'); ?>

<h1>Transaction <small>#<?php echo $transaction['message_id']; ?></small></h1>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/dropdown', array('id' => 'label_id', 'value' => $transaction['label_id'])); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Modify</button>
  </div>
</div>

<?php echo form_close(); ?>
