<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>History</h1>

<?php if (empty($message_send_history)): ?>
  <p class="lead text-muted">No message found</p>
<?php else: ?>
  <div class="list-group">
    <?php foreach ($message_send_history as $history): ?>
      <a class="list-group-item" href="<?php echo base_url('message/archive/'.$history['request_id'].'/'.$history['verify_id']); ?>" target="_blank">
        <div class="media">
          <div class="media-body">
            <h5 class="media-heading">
              <?php echo $history['subject']; ?>
              <small>
                <span class="text-uppercase"><?php echo $history['owner']; ?></span>
                #<?php echo $history['message_id']; ?>

                <?php if ($history['sent'] != '1000-01-01 00:00:00') {
                  echo date('M d, Y h:i A', strtotime($history['sent']));
                } ?>

                <strong class="pull-right"><?php echo $history['to_email']; ?></strong>
              </small>
            </h5>
          </div>

          <div class="media-right">
            <span class="media-object glyphicon glyphicon-<?php echo ($history['sent'] == '1000-01-01 00:00:00' ? 'time' : 'ok'); ?>"></span>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>