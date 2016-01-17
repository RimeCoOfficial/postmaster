<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  <?php echo $message['subject']; ?>
  <small>#<?php echo $message['message_id']; ?></small>
  <span class="pull-right label label-default"><?php echo $message['owner']; ?></span>
</h1>

<p>
  Reply-to:
  <?php echo $message['reply_to_name']; ?>
  <?php if (!empty($message['reply_to_email'])) echo '('.$message['reply_to_email'].')'; ?>
</p>

<h5>
  HTML
  <small>
    <a href="<?php echo base_url('message/show/'.$message['message_id'].'/1'); ?>" target="_blank">
      <span class="glyphicon glyphicon-new-window"></span>
    </a>
  </small>
</h5>
<div class="embed-responsive embed-responsive-4by3">
  <iframe src="data:text/html;charset=utf-8,<?php echo htmlentities($message['body_html']); ?>"></iframe>
</div>

<h5>Text</h5>
<div class="well well-lg"><?php echo $message['body_text']; ?></div>
