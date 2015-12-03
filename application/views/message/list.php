<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Messages</h1>

<?php // var_dump($list); ?>

<?php if (!empty($list)): ?>
  <div class="list-group">
    <?php foreach ($list as $message): ?>
      <div class="list-group-item">
        <div class="media">
          <div class="media-body">
            <h5 class="media-heading">
              <?php
              $is_draft = $message['published'] == '1000-01-01 00:00:00';
              echo anchor('message/show/'.$message['message_id'], $message['subject'], 'target="_blank"'.($is_draft ? 'class="text-muted"' : '')); ?>
              <small>
                #<?php echo $message['message_id']; ?>
                <span class="text-uppercase"><?php echo $message['owner']; ?></span>
                <?php echo $message['reply_to_name']; ?>
                <?php echo $message['reply_to_email']; ?>
                <?php if (!empty($message['tumblr_post_id'])) echo $message['tumblr_post_id']; ?>
                <?php echo date('M d, Y h:i A', strtotime($message['created'])); ?>
              </small>
            </h5>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>