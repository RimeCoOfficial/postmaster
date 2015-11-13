<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav'); ?>

<h1>Labels <span><a href="<?php echo base_url('transaction/label/create'); ?>" class="btn btn-primary pull-right">New</a></span></h1>

<?php // var_dump($label_list); ?>

<?php if (!empty($label_list)): ?>
<table class="table">
  <!-- <caption>List</caption> -->
  <thead>
    <tr>
      <th>Name</th>
      <!-- <th>Reply-to Name</th> -->
      <!-- <th>Reply-to Email</th> -->
      <th>Edit</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($label_list as $key => $label): ?>
    <tr>
      <th scope="row"><?php echo anchor('transaction/label/modify/'.$label['label_id'], $label['name']); ?></th>
      <!-- <td><?php echo $label['reply_to_name']; ?></td> -->
      <!-- <td><?php echo $label['reply_to_email']; ?></td> -->
      <td><a href="<?php echo base_url('transaction/label/modify/'.$label['label_id']); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>