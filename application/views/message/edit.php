<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  <?php echo $message['subject']; ?>
</h1>

<p class="lead">
  #<?php echo $message['message_id']; ?>
  
  List-unsubscribe: <?php echo $message['list']; ?>

  <span class="pull-right">
    <span class="label label-default"><?php echo $message['type']; ?></span>
  </span>
</p>

<?php // var_dump($message); ?>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'subject', 'value' => $message['subject'])); ?>

<?php $this->view('form/input', array('id' => 'reply_to_name', 'value' => $message['reply_to_name'])); ?>
<?php $this->view('form/input', array('id' => 'reply_to_email', 'value' => $message['reply_to_email'])); ?>

<?php $this->view('form/textarea', array('id' => 'body_html_input', 'value' => $message['body_html_input'])); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">
      <span class="glyphicon glyphicon-floppy-save"></span>
    </button>
  </div>
  <div class="col-sm-7">
    <p class="h6">
      <a href="<?php echo base_url('message/view/'.$message['message_id'].'/html'); ?>" target="_blank">HTML <span class="glyphicon glyphicon-new-window"></span></a>
    </p>
  </div>
</div>

<?php echo form_close(); ?>

<br>
