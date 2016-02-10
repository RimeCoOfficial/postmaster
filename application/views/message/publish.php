<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  <?php echo $message['subject']; ?>
</h1>

<p class="lead">
  #<?php echo $message['message_id']; ?>
  
  List-unsubscribe: <?php echo anchor('list-unsubcribe/#', $message['list']); ?>

  <span class="pull-right">
    <a href="<?php echo base_url('message/#'); ?>">
      <span class="label label-default"><?php echo $message['type']; ?></span>
    </a>
  </span>
</p>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'php_datetime_str', 'value' => NULL)); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Publish</button>
  </div>
</div>

<?php echo form_close(); ?>

<br>

<div class="panel panel-default">
  <div class="panel-heading">Supported Date and Time Formats</div>
  <table class="table table-striped">
    <thead>
      <tr><th>Formats</th> <th>Examples</th></tr>
    </thead>

    <tbody>
      <?php
      if ($message['type'] == 'campaign')
      {
        ?>
        <tr>
          <th scope="row"><a href="http://php.net/manual/en/datetime.formats.time.php" target="_blank">Time Formats</a></th>
          <td>"4 am", "4:08:37 am"</td>
        </tr>
        <tr>
          <th scope="row"><a href="http://php.net/manual/en/datetime.formats.date.php" target="_blank">Date Formats</a></th>
          <td>"July 1st", "2008/06/30", "08-06-30"</td>
        </tr>
        <tr>
          <th scope="row"><a href="http://php.net/manual/en/datetime.formats.relative.php" target="_blank">Compound Formats</a></th>
          <td>"20080701T22:38:07", "@1215282385"</td>
        </tr>
        <?php
      }
      ?>

      <tr>
        <th scope="row"><a href="http://php.net/manual/en/datetime.formats.relative.php" target="_blank">Relative Formats</a></th>
        <td>"now", "yesterday noon", "+5 weeks"</td>
      </tr>
    </tbody>
  </table>
</div>