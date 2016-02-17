<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Messages</h1>

<?php // var_dump($list); ?>

<?php if (empty($list)): ?>
  <p class="lead text-muted">No message found</p>
<?php else: ?>
  <div class="list-group">
    <?php foreach ($list as $message): ?>
      <div class="list-group-item">
        <div class="media">
          <div class="media-body">
            <h5 class="media-heading">
              <a href="<?php echo base_url('message/view/'.$message['message_id']); ?>"
                class="<?php echo ($message['archived'] == '1000-01-01 00:00:00') ? '' : 'text-muted'; ?>"
              >
                <?php echo $message['subject']; ?>
              </a>
            </h5>
            
            <small>
              #<?php echo $message['message_id']; ?>
              
              <!-- <span><?php echo anchor('message?filter=list_id:'.$message['list_id'], $message['list']); ?></span> -->
              <?php echo $message['list']; ?>

              <?php echo $message['reply_to_name']; ?>
              <?php echo $message['reply_to_email']; ?>
              <?php echo date('M d, Y h:i A', strtotime($message['created'])); ?>
            </small>
          </div>

          <div class="media-right">
            <!-- <a href="<?php echo base_url('message?filter=list_type:'.$message['type']); ?>"> -->
              <span class="media-object label label-default">
                <?php echo $message['type']; ?>
              </span>
            <!-- </a> -->
          </div>

          <div class="media-right">
            <?php
            $title = NULL;
            $icon = NULL;
            $is_primary = 'muted';
            if ($message['archived'] != '1000-01-01 00:00:00')  { $title = 'Archived';  $icon = 'disk';  }
            else if (!is_null($message['published_tds']))       { $title = 'Published'; $icon = 'saved'; }
            else                                                { $title = 'Draft';     $icon = 'save';  $is_primary = 'primary'; }
            ?>
            <div class="text-<?php echo $is_primary; ?>"
              title="<?php echo $title; ?>"
              data-toggle="tooltip"
              data-placement="bottom">
              <span class="media-object glyphicon glyphicon-floppy-<?php echo $icon; ?>" aria-hidden="true"></span>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
