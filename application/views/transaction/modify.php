<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav'); ?>

<h1>Transaction <small>#<?php echo $message['message_id']; ?></small></h1>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'subject', 'value' => $message['subject'])); ?>

<?php $this->view('form/dropdown', array('id' => 'label_id', 'value' => $message['label_id'])); ?>

<?php $this->view('form/input', array('id' => 'reply_to_name', 'value' => $message['reply_to_name'])); ?>
<?php $this->view('form/input', array('id' => 'reply_to_email', 'value' => $message['reply_to_email'])); ?>

<?php $this->view('form/textarea', array('id' => 'body_html_input', 'value' => $message['body_html_input'])); ?>


<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Modify</button>
  </div>
  <div class="col-sm-2">
    <a href="<?php echo base_url('transaction/message/archive/'.$message['message_id']); ?>" class="btn btn-danger btn-block">
      <span class="glyphicon glyphicon-trash"></span>
    </a>
  </div>
</div>

<?php echo form_close(); ?>
