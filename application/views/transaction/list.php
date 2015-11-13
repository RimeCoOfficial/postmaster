<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav'); ?>

<h1>Transactions <span><a href="<?php echo base_url('transaction/home/create'); ?>" class="btn btn-primary pull-right">Create</a></span></h1>

<?php // var_dump($list); ?>

<?php if (!empty($list)): ?>
<table class="table">
  <caption>List</caption>
  <thead>
    <tr>
      <th>id</th>
      <th>Subject</th>
      <!-- <th>Label</th> -->
    </tr>
  </thead>

  <tbody>
    <?php foreach ($list as $key => $transaction): ?>
    <tr>    
      <th scope="row"><?php echo $transaction['transaction_id']; ?></th>
      <td>
        <strong><?php echo anchor('transaction/home/modify/'.$transaction['transaction_id'], $transaction['subject']); ?></strong>
        <?php echo !empty($transaction['label_name']) ? '<span class="label label-default">'.$transaction['label_name'].'</span class="label label-default">' : ''; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>