<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Transactions <span><a href="<?php echo base_url('transaction/create'); ?>" class="btn btn-primary pull-right">Create</a></span></h1>

<?php // var_dump($list); ?>

<?php if (!empty($list)): ?>
<table class="table">
  <caption>List</caption>
  <thead>
    <tr>
      <th>id</th>
      <th>Name</th>
      <th>Category</th>
      <th>Reply-to Name</th>
      <th>Reply-to Email</th>
      <!-- <th>Templates</th> -->
    </tr>
  </thead>

  <tbody>
    <?php foreach ($list as $key => $transaction): ?>
    <tr>    
      <th scope="row"><?php echo $transaction['transaction_id']; ?></th>
      <td><?php echo anchor('transaction/modify/'.$transaction['transaction_id'], $transaction['subject']); ?></td>
      <td><?php echo $transaction['category_id']; ?></td>
      <td><?php echo $transaction['reply_to_name']; ?></td>
      <td><?php echo $transaction['reply_to_email']; ?></td>
      <!-- <td>0</td> -->
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>