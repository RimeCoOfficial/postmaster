<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Categories <span><a href="<?php echo base_url('transactional/create-category'); ?>" class="btn btn-primary pull-right">New</a></span></h1>

<?php // var_dump($category_list); ?>

<table class="table">
  <caption>Categories</caption>
  <thead>
    <tr>
      <th>id</th>
      <th>Name</th>
      <th>Reply-to Name</th>
      <th>Reply-to Email</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($category_list as $key => $category): ?>
    <tr>    
      <th scope="row"><?php echo $category['transaction_category_id']; ?></th>
      <td><?php echo $category['category']; ?></td>
      <td><?php echo $category['reply_to_name']; ?></td>
      <td><?php echo $category['reply_to_email']; ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>