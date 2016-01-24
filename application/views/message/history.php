<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>History</h1>

<?php if (empty($message_archive_list)): ?>
  <p class="lead text-muted">No message found</p>
<?php else: ?>
  <div class="list-group">
    <?php foreach ($message_archive_list as $request): ?>
      <?php if (empty($request['web_version_key'])): ?>
        <a class="list-group-item disabled">
          <div class="media">
            <div class="media-body">
              <h5 class="media-heading">
                <code>[<?php echo $request['request_id']; ?>] Processing request</code>
                <small>
                  <span class="text-uppercase"><?php echo $request['owner']; ?></span>
                  #<?php echo $request['message_id']; ?>,

                  requested <?php echo date('M d, Y h:i A', strtotime($request['created'])); ?>

                  <strong class="pull-right"><?php echo $request['to_email']; ?></strong>
                </small>
              </h5>
            </div>

            <div class="media-right text-info">
              <span class="media-object glyphicon glyphicon-transfer"></span>
            </div>
          </div>
        </a>
      <?php else: ?>
        <a class="list-group-item" href="<?php echo base_url('message/archive/'.$request['request_id'].'/'.$request['web_version_key']); ?>" target="_blank">
          <div class="media">
            <div class="media-body">
              <h5 class="media-heading">
                <?php echo $request['subject']; ?>
                <small>
                  <span class="text-uppercase"><?php echo $request['owner']; ?></span>
                  #<?php echo $request['message_id']; ?>,

                  <?php if ($request['sent'] != '1000-01-01 00:00:00') {
                    echo 'sent '.date('M d, Y h:i A', strtotime($request['sent']));
                  }
                  else
                  {
                     echo 'requested '.date('M d, Y h:i A', strtotime($request['created']));
                  }
                  ?>

                  <strong class="pull-right"><?php echo $request['to_email']; ?></strong>
                </small>
              </h5>
            </div>

            <div class="media-right text-<?php echo ($request['sent'] == '1000-01-01 00:00:00' ? 'info' : 'success'); ?>">
              <span class="media-object glyphicon glyphicon-<?php echo ($request['sent'] == '1000-01-01 00:00:00' ? 'hourglass' : 'ok-sign'); ?>"></span>
            </div>
          </div>
        </a>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
<?php endif; ?>