<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Requests</h1>

<?php if (empty($archive_list)): ?>
  <p class="lead text-muted">No message found</p>
<?php else: ?>
  <div class="list-group">
    <?php foreach ($archive_list as $request): ?>
      <div class="list-group-item">
        <div class="media">
          <div class="media-body">
            <h5 class="media-heading">
              <?php
              if (empty($request['web_version_key']))
              {
                
                ?>
                <samp class="text-muted"><strong>
                  <?php
                    $text = !empty($request['processed_error']) ? $request['processed_error'] : 'Request accepted';
                    echo '['.$request['request_id'].'] '.$text;
                  ?>
                </strong></samp>
                <?php
              }
              else echo $request['subject'];
              ?>

              <small class="text-muted">
                #<?php echo $request['message_id']; ?>
                
                <?php echo $request['list']; ?>

                <strong>
                  <?php echo $request['to_email']; ?>
                </strong>
              </small>
            </h5>


            <?php
            ?>
            <samp class="small">
              <?php
              if (!empty($request['sent']) AND $request['sent'] != '1000-01-01 00:00:00')
              {
                echo date('M d, Y h:i A', strtotime($request['sent'])).' GMT';
              }
              elseif (!empty($request['processed_error']))
              {
                echo date('M d, Y h:i A', strtotime($request['processed'])).' GMT '.'Processing failed!';
              }
              elseif (!empty($request['processed']) AND $request['processed'] != '1000-01-01 00:00:00')
              {
                echo date('M d, Y h:i A', strtotime($request['processed'])).' GMT '.'Sending mail...';
              }
              else // if (!empty($request['created']))
              {
                echo date('M d, Y h:i A', strtotime($request['created'])).' GMT '.'Processing request...';
              }
              ?>
            </samp>

            <?php
            if (!empty($request['ses_feedback_json']))
            {
              $collapse_id = 'collapseExample'.$request['request_id'];
              ?>
              <a role="button" data-toggle="collapse" href="#<?php echo $collapse_id; ?>" aria-expanded="false" aria-controls="collapseExample">&hellip;</a>
              <?php
            }
            ?>
          </div>

          <div class="media-right">
            <span class="media-object label label-default">
              <?php echo $request['type']; ?>
            </span>
          </div>

          <?php
          if (empty($request['web_version_key']))
          {
            ?>
            <div class="media-right text-info">
              <span class="media-object glyphicon glyphicon-transfer"></span>
            </div>
            <?php
          }
          else
          {
            ?>
            <div class="media-right">
              <a class="text-<?php echo ($request['sent'] == '1000-01-01 00:00:00' ? 'info' : 'success'); ?>" href="<?php echo base_url('open/message/'.$request['request_id'].'/'.$request['web_version_key']); ?>" target="_blank">
                <span class="media-object glyphicon glyphicon-<?php echo ($request['sent'] == '1000-01-01 00:00:00' ? 'hourglass' : 'ok-sign'); ?>"></span>
              </a>
            </div>
            <?php
          }
          ?>

          <?php
          if (!empty($collapse_id))
          {
            ?>
            <div class="collapse" id="<?php echo $collapse_id; ?>">
              <?php
              $data = json_decode($request['ses_feedback_json']);
              $json_string = json_encode($data, JSON_PRETTY_PRINT);
              ?>
              <pre class="text-wrap" style="margin-top: 5px;"><?php echo $json_string; ?></pre>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>