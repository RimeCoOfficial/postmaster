<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>New Message</h1>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'subject', 'value' => NULL)); ?>

<?php // $this->view('form/input', array('id' => 'reply_to_name', 'value' => NULL)); ?>
<?php // $this->view('form/input', array('id' => 'reply_to_email', 'value' => NULL)); ?>

<?php // $this->view('form/textarea', array('id' => 'body_html_input', 'value' => NULL)); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Create</button>
  </div>
</div>

<?php echo form_close(); ?>
