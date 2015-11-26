<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Message <small><?php echo strtoupper($message['owner']); ?> #<?php echo $message['message_id']; ?></small></h1>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'subject', 'value' => $message['subject'])); ?>

<?php $this->view('form/input', array('id' => 'reply_to_name', 'value' => $message['reply_to_name'])); ?>
<?php $this->view('form/input', array('id' => 'reply_to_email', 'value' => $message['reply_to_email'])); ?>

<?php $this->view('form/textarea', array('id' => 'message_html', 'value' => $message['message_html'])); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Modify</button>
  </div>
</div>

<?php echo form_close(); ?>

<br>
<p>
  <a href="<?php echo base_url('message/show/'.$message['message_id']); ?>" target="_blank">Show HTML</a>
</p>