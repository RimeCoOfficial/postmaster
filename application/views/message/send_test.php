<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  <?php echo $message['subject']; ?>
  <small>#<?php echo $message['message_id']; ?></small>
</h1>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'email', 'value' => NULL)); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Send</button>
  </div>
</div>
