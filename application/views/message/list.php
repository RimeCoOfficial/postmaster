<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Messages <span><a href="<?php echo base_url('message/create'); ?>" class="btn btn-primary pull-right">Create</a></span></h1>

<?php // var_dump($list); ?>

<?php if (!empty($list)): ?>
<table class="table">
  <caption>List</caption>
  <thead>
    <tr>
      <th>id</th>
      <th>Subject</th>
      <th>Reply-to Name</th>
      <th>Reply-to Email</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($list as $key => $message): ?>
    <tr>    
      <th scope="row"><?php echo $message['message_id']; ?></th>
      <td><?php echo anchor('message/home/modify/'.$message['message_id'], $message['subject']); ?></td>
      <td><?php echo $message['reply_to_name']; ?></td>
      <td><?php echo $message['reply_to_email']; ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>