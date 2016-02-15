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
                <samp class="small">Processing request [<?php echo $request['request_id']; ?>]</samp>
                <?php
              }
              else
              {
                // $request['ses_feedback_json'] = json_encode(['value' => 'value']);

                if (!empty($request['ses_feedback_json']))
                {
                  $collapse_id = 'collapseExample'.$request['request_id'];
                  ?>
                  <a class="" role="button" data-toggle="collapse" href="#<?php echo $collapse_id; ?>" aria-expanded="false" aria-controls="collapseExample">
                    <?php echo $request['subject']; ?>
                  </a>
                  <?php
                }
                else echo $request['subject'];
              }
              ?>
            </h5>

            <small>
              #<?php echo $request['message_id']; ?>
              
              <span class="text-uppercase">
                <a href="<?php echo base_url('stats/history?filter=list_id:'.$request['list_id']); ?>" class="text-muted"><?php echo $request['list']; ?></a>
              </span>

              <strong>
                <a href="<?php echo base_url('stats/history?filter=to_email:'.urlencode($request['to_email'])); ?>" class="text-muted"><?php echo $request['to_email']; ?></a>
              </strong>

              <?php
              if (empty($request['web_version_key']))
              {
                echo 'requested '.date('M d, Y h:i A', strtotime($request['created']));
              }
              else
              {
                echo 'sent '.date('M d, Y h:i A', strtotime($request['sent']));
              }
              ?>
            </small>

            <?php
            if (!empty($request['ses_feedback_json']))
            {
              ?>
              <div class="collapse" id="<?php echo $collapse_id; ?>">
                <?php
                $data = json_decode($request['ses_feedback_json']);
                $json_string = json_encode($data, JSON_PRETTY_PRINT);
                ?>
                <pre><?php echo $json_string; ?></pre>
              </div>
              <?php
            }
            ?>
          </div>

          <div class="media-right">
            <a href="<?php echo base_url('stats/history?filter=list_type:'.$request['type']); ?>">
              <span class="media-object label label-default">
                <?php echo $request['type']; ?>
              </span>
            </a>
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
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>