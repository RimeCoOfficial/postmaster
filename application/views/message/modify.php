<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  <?php echo $message['subject']; ?>
  <small>#<?php echo $message['message_id']; ?></small>
  <span class="pull-right label label-default"><?php echo $message['list']; ?></span>
</h1>

<h2>List-unsubscribe: <?php echo $message['list']; ?> <small>#<?php echo $message['list_id']; ?></small></h2>

<?php // var_dump($message); ?>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'subject', 'value' => $message['subject'])); ?>
<?php $this->view('form/dropdown', array('id' => 'owner', 'value' => $message['owner'])); ?>

<?php $this->view('form/input', array('id' => 'list_id', 'value' => $message['list_id'])); ?>

<?php $this->view('form/input', array('id' => 'reply_to_name', 'value' => $message['reply_to_name'])); ?>
<?php $this->view('form/input', array('id' => 'reply_to_email', 'value' => $message['reply_to_email'])); ?>

<?php $this->view('form/textarea', array('id' => 'body_html_input', 'value' => $message['body_html_input'])); ?>


<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Modify</button>
  </div>
  <div class="col-sm-7">
    <p class="h6">
      <a href="<?php echo base_url('message/show/'.$message['message_id']); ?>" target="_blank">Show HTML</a>
    </p>
  </div>
</div>

<?php echo form_close(); ?>

<br>

<div class="panel panel-warning">
  <div class="panel-heading">
    <h3 class="panel-title">
      Warning Zone
    </h3>
  </div>
  <div class="panel-body">
    <a href="<?php echo base_url('transactional/message/archive/'.$message['message_id']); ?>" class="btn btn-warning pull-right">
      <span class="glyphicon glyphicon-compressed"></span>
    </a>
    <dl>
      <dt>Archive</dt>
      <dd>Archived transactional wont accept <strong>new</strong> requests.</dd>
      <dd>But you can restore and use it again.</dd>
    </dl>
  </div>
</div>
