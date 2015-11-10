<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav'); ?>

<h1>Categories <span><a href="<?php echo base_url('transaction/category/create'); ?>" class="btn btn-primary pull-right">New</a></span></h1>

<?php // var_dump($category_list); ?>

<?php if (!empty($category_list)): ?>
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
    <?php foreach ($category_list as $key => $category): ?>
    <tr>
      <th scope="row"><?php echo anchor('transaction/category/modify/'.$category['category_id'], $category['name']); ?></th>
      <!-- <td><?php echo $category['reply_to_name']; ?></td> -->
      <!-- <td><?php echo $category['reply_to_email']; ?></td> -->
      <td><a href="<?php echo base_url('transaction/category/modify/'.$category['category_id']); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>