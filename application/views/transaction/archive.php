<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav'); ?>

<h1>
  <?php echo $message['subject']; ?>
  <small>#<?php echo $message['message_id']; ?></small>

  <span class="pull-right label label-default"><?php echo $message['label']; ?></span>
</h1>

<div class="jumbotron">
Reply-to: <?php echo $message['reply_to_name']; ?> &lt;<?php echo $message['reply_to_email']; ?>&gt;
<p><?php echo strip_tags($message['body_html_input']); ?></p>
</div>

<div class="row">
  <div class="col-sm-2">
    <a href="<?php echo base_url('transaction/message/unarchive/'.$message['message_id']); ?>" class="btn btn-primary btn-block">
      Restore
    </a>
  </div>
</div>
