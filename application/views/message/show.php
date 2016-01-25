<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  <?php echo $message['subject']; ?>
  <small>#<?php echo $message['message_id']; ?></small>
</h1>

<p class="lead">
  List-unsubscribe: <?php echo anchor('list-unsubcribe/#', $message['list']); ?>

  <a href="<?php echo base_url('message/#'); ?>">
    <span class="pull-right label label-default"><?php echo $message['type']; ?></span>
  </a>
</p>

<p>
  Reply-to:
  <?php echo $message['reply_to_name']; ?>
  <?php if (!empty($message['reply_to_email'])) echo '('.$message['reply_to_email'].')'; ?>
</p>



<p class="small pull-right">
  <a data-toggle="modal" data-target="#htmlModal" href="#">HTML</a>
  <a href="<?php echo base_url('message/show/'.$message['message_id'].'/1'); ?>" target="_blank"><span class="glyphicon glyphicon-new-window"></span></a>
</p>
<div class="clearfix"></div>
<div class="well well-lg"><?php echo $message['body_text']; ?></div>

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



<?php
if ($message['archived'] == '1000-01-01 00:00:00')
{
  ?>
  <div class="panel panel-default">
    <!-- <div class="panel-heading">
      <h3 class="panel-title">Edit</h3>
    </div> -->
    <div class="panel-body">
      <a href="<?php echo base_url('message/modify/'.$message['message_id']); ?>" class="btn btn-primary pull-right">
        <span class="glyphicon glyphicon-edit"></span>
      </a>
      <dl>
        <dt>Edit</dt>
        <dd>Make changes!</dd>
      </dl>
    </div>
  </div>

  <div class="panel panel-warning">
    <div class="panel-heading">
      <h3 class="panel-title">Warning Zone</h3>
    </div>
    <div class="panel-body">
      <a href="<?php echo base_url('message/archive/'.$message['message_id'].'/'.$message['type']); ?>" class="btn btn-warning pull-right">
        <!-- <span class="glyphicon glyphicon-compressed"></span> -->
        <span class="glyphicon glyphicon-trash"></span>
      </a>
      <dl>
        <dt>Archive</dt>
        <dd>Archived messages wont accept <strong>new</strong> requests.</dd>
        <dd>But you can restore and use it again.</dd>
      </dl>
    </div>
  </div>
  <?php
}
else
{
  ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <a href="<?php echo base_url('message/unarchive/'.$message['message_id'].'/'.$message['type']); ?>" class="btn btn-primary pull-right">
        <!-- <span class="glyphicon glyphicon-compressed"></span> -->
        <span class="glyphicon glyphicon-repeat"></span>
      </a>
      <dl>
        <dt>Unrchive</dt>
        <dd>Restore messages to use it again.</dd>
      </dl>
    </div>
  </div>
  <?php
}
?>