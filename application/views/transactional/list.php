<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Templates <span><a href="<?php echo base_url('transactional/create'); ?>" class="btn btn-primary pull-right">Create</a></span></h1>

<?php var_dump($list); ?>

<?php if (!empty($category_list)): ?>
<table class="table">
  <caption>List</caption>
  <thead>
    <tr>
      <th>Name</th>
      <th>Reply-to Name</th>
      <th>Reply-to Email</th>
      <th>Templates</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($category_list as $key => $category): ?>
    <tr>    
      <th scope="row"><?php echo anchor('transactional/category/'.$category['transaction_category_id'], $category['category']); ?></th>
      <td><?php echo $category['reply_to_name']; ?></td>
      <td><?php echo $category['reply_to_email']; ?></td>
      <td>0</td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>