<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  <?php echo $message['subject']; ?>
  <small>#<?php echo $message['message_id']; ?></small>
</h1>

<?php // var_dump($message); ?>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'subject', 'value' => $message['subject'])); ?>
<?php $this->view('form/dropdown', array('id' => 'type', 'value' => $message['type'])); ?>

<?php $this->view('form/input', array('id' => 'list_id', 'value' => $message['list_id'])); ?>

<?php $this->view('form/input', array('id' => 'reply_to_name', 'value' => $message['reply_to_name'])); ?>
<?php $this->view('form/input', array('id' => 'reply_to_email', 'value' => $message['reply_to_email'])); ?>

<?php $this->view('form/textarea', array('id' => 'body_html_input', 'value' => $message['body_html_input'])); ?>


<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Update</button>
  </div>
  <div class="col-sm-7">
    <p class="h6">
      <a href="<?php echo base_url('message/view/'.$message['message_id'].'/1'); ?>" target="_blank">Show HTML</a>
    </p>
  </div>
</div>

<?php echo form_close(); ?>

<br>
