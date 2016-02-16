<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  <?php echo $message['subject']; ?>

  <?php if ($message['archived'] == '1000-01-01 00:00:00'): ?>
    <span class="pull-right">
      <a href="<?php echo base_url('message/edit/'.$message['message_id']); ?>" class="btn btn-default">Edit</a>
    </span>
  <?php endif; ?>
</h1>

<p class="lead">
  #<?php echo $message['message_id']; ?>

  List-unsubscribe: <?php echo $message['list']; ?>

  <span class="pull-right">
    <span class="label label-default"><?php echo $message['type']; ?></span>
  </span>
</p>

<p>
  Reply-to:
  <?php echo $message['reply_to_name']; ?>
  <?php if (!empty($message['reply_to_email'])) echo '('.$message['reply_to_email'].')'; ?>
</p>

<p class="lead"><?php echo $message['body_text']; ?></p>

<div class="row">
  <div class="col-sm-5">
    <a data-toggle="modal" data-target="#sendTestModal" href="#" class="btn btn-default btn-block">Send test mail</a>
  </div>
  <div class="col-sm-7">
    <p class="h6">
      <a data-toggle="modal" data-target="#htmlModal" href="#">HTML</a>
      <a href="<?php echo base_url('message/view/'.$message['message_id'].'/html'); ?>" target="_blank"><span class="glyphicon glyphicon-new-window"></span></a>
    </p>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="htmlModal" tabindex="-1" role="dialog" aria-labelledby="htmlModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="htmlModalLabel">HTML Preview</h4>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-4by3">
          <iframe src="data:text/html;charset=utf-8,<?php echo htmlentities($message['body_html']); ?>"></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php $this->view('message/send_test'); ?>

<br>
<br>

<?php
// drafting - Edit, Publish
// published - Edit, Draft
// archived - info

if ($message['archived'] == '1000-01-01 00:00:00')
{
  if (is_null($message['published_tds']) AND $message['type'] != 'transactional')
  {
    // drafting
    ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Publish</h3>
      </div>
      <div class="panel-body">
        <div class="media">
          <div class="media-body">
            <p>Send emails!</p>
          </div>
          <div class="media-right">
            <a href="<?php echo base_url('message/publish/'.$message['message_id']); ?>" class="btn btn-primary">
              <div class="media-object">
                <span class="glyphicon glyphicon-floppy-saved"></span>
                <span class="sr-only">Publish</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
  else
  {
    // published = re-publish
    if ($message['type'] != 'transactional')
    {
      ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Published</h3>
        </div>
        <div class="panel-body">
          <div class="media">
            <div class="media-body">
              <p>
                The message has been published 
                <abbr title="published_tds=<?php echo $message['published_tds'] ?>">
                  <?php
                  switch ($message['type']) {
                    case 'autoresponder':
                      echo '+';
                      if      ($message['published_tds'] / (60*24*30) > 1) echo $message['published_tds'] / (60*24*30).' months';
                      else if ($message['published_tds'] / (60*24)    > 1) echo $message['published_tds'] / (60*24)   .' days';
                      else if ($message['published_tds'] / (60)       > 1) echo $message['published_tds'] / (60)      .' minutes';
                      else                                                 echo $message['published_tds']             .' seconds';
                      break;
                    
                    case 'campaign':
                      $date_from_str = '1000-01-01 00:00:00';
                      $date_from = strtotime($date_from_str);

                      echo date('Y-m-d H:i:s', $message['published_tds'] + $date_from). ' GMT';
                      break;

                    case 'transactional':
                      echo 'at zero (0)';
                      break;
                  }
                  ?>
                </abbr>
              </p>
            </div>
            <div class="media-right">
              <a href="<?php echo base_url('message/publish/'.$message['message_id']); ?>" class="btn btn-default">
                <div class="media-object">
                  <span class="glyphicon glyphicon-floppy-saved"></span>
                  <span class="sr-only">Publish</span>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php
    }

    if (!is_null($message['published_tds']) AND $message['type'] != 'campaign')
    {
      ?>
      <div class="panel panel-warning">
        <div class="panel-heading">
          <h3 class="panel-title">Warning Zone</h3>
        </div>
        <div class="panel-body">
          <div class="media">
            <div class="media-body">
              <h5 class="media-heading">Archive</h5>
              <ul class="list-unstyled-disabled">
                <li>Archived messages wont accept <strong>new</strong> requests.</li>
                <li>But you can unarchive and use it again.</li>
                <li>If you want to make some changes to the content use <strong>Edit</strong>.</li>
              </ul>
            </div>
            <div class="media-right">
              <a href="<?php echo base_url('message/archive/'.$message['message_id']); ?>" class="btn btn-warning">
                <div class="media-object">
                  <span class="glyphicon glyphicon-floppy-remove"></span>
                  <span class="sr-only">Archive</span>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php
    }
  }
}
else
{
  ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Archived</h3>
    </div>
    <div class="panel-body">
      <div class="media">
        <div class="media-body">
          <p>
            The message has been archived.
            <abbr title="<?php
              $archived_str = strtotime($message['archived']);
              // Tuesday 8:53 AM, Jan 26 2016
              echo time_ago($archived_str);
              ?>">
              <?php echo date('l g:i A, M j Y', $archived_str); ?> GMT
            </abbr>
          </p>
        </div>

        <?php if ($message['type'] != 'campaign'): ?>
          <div class="media-right">
            <a href="<?php echo base_url('message/unarchive/'.$message['message_id']); ?>" class="btn btn-default">
              <div class="media-object">
                <span class="glyphicon glyphicon-floppy-open"></span>
                <span class="sr-only">Unarchive</span>
              </div>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php
}
?>
