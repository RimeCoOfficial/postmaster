<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav'); ?>

<h1>Transaction <small>#<?php echo $transaction['transaction_id']; ?></small></h1>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'subject', 'value' => $transaction['subject'])); ?>

<?php $this->view('form/input', array('id' => 'reply_to_name', 'value' => $transaction['reply_to_name'])); ?>
<?php $this->view('form/input', array('id' => 'reply_to_email', 'value' => $transaction['reply_to_email'])); ?>

<?php $this->view('form/textarea', array('id' => 'body_html', 'value' => $transaction['body_html'])); ?>

<?php $this->view('form/dropdown', array('id' => 'category_id', 'value' => $transaction['category_id'])); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Modify</button>
  </div>
</div>

<?php echo form_close(); ?>
