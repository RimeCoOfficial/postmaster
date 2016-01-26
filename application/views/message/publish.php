<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  <?php echo $message['subject']; ?>
  <small>#<?php echo $message['message_id']; ?></small>
</h1>

<div class="well">
  <div class="label label-default pull-right"><?php echo $message['type']; ?></div>

  <dl class="dl-horizontal">
  <?php
  switch ($message['type']) {
    case 'autoresponder':
      ?>
      <dt><a href="http://php.net/manual/en/datetime.formats.relative.php" target="_blank">Relative Formats</a></dt>
      <dd>"now"</dd>
      <?php
      break;

    case 'campaign':
      ?>
      <dt><a href="http://php.net/manual/en/datetime.formats.time.php" target="_blank">Time Formats</a></dt>
      <dd>"4 am", "4:08:37 am"</dd>
      <dt><a href="http://php.net/manual/en/datetime.formats.date.php" target="_blank">Date Formats</a></dt>
      <dd>"July 1st", "2008/06/30", "08-06-30"</dd>
      <dt><a href="http://php.net/manual/en/datetime.formats.relative.php" target="_blank">Compound Formats</a></dt>
      <dd>"20080701T22:38:07", "@1215282385"</dd>
      <?php
      break;
    
    case 'transactional':
      break;
  }
  ?>
  </dl>
</div>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'php_datetime_str', 'value' => NULL)); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Publish</button>
  </div>
  <div class="col-sm-7">
    <p class="h6">
      <a href="<?php echo base_url('message/view-html/'.$message['message_id']); ?>" target="_blank">Show HTML</a>
    </p>
  </div>
</div>
