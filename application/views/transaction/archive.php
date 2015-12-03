<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav'); ?>

<h1>Transaction <small>#<?php echo $message['message_id']; ?></small></h1>

<div class="jumbotron">
<h3><?php echo $message['subject']; ?> <small><?php echo $message['label']; ?></small></h3>

<?php echo $message['reply_to_name']; ?> <?php echo $message['reply_to_email']; ?>
<p><?php echo strip_tags($message['body_html_input']); ?></p>
</div>

<div class="row">
  <div class="col-sm-2">
    <a href="<?php echo base_url('transaction/message/unarchive/'.$message['message_id']); ?>" class="btn btn-primary btn-block">
      Restore
    </a>
  </div>
</div>
