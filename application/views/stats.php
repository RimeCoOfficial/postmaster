<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Stats</h1>

<table class="table">
  <caption>Amazon SES</caption>
  <thead>
    <tr>
      <th>Status</th>
      <th>Type</th>
      <th>Timestamp</th>
      <th>Count</th>
    </tr>
  </thead>

  <tbody>
    <?php
    $total = 0;
    foreach ($stats['aws'] as $s)
    {
      $total += $s['count'];
      ?>
      <tr>
        <th scope="row"><?php echo $s['status']; ?></th>
        <td><?php echo $s['status_type']; ?></td>
        <td><?php echo $s['status_timestamp']; ?></td>
        <td><?php echo $s['count']; ?></td>
      </tr>
      <?php
    }
    ?>

    <tr>
      <th scope="row">Total</th>
      <td></td>
      <td></td>
      <td><?php echo $total; ?></td>
    </tr>
  </tbody>
</table>

<?php
// var_dump($stats['unsubscribe']);
?>
<table class="table">
  <caption>Unsubscribe</caption>
  <thead>
    <tr>
      <th>Type</th>
      <th>Count</th>
    </tr>
  </thead>

  <tbody>
    <?php
    foreach ($stats['unsubscribe'] as $key => $s)
    {
      ?>
      <tr>
        <th scope="row"><?php echo $key; ?></th>
        <td><?php echo $s; ?></td>
      </tr>
      <?php
    }
    ?>
  </tbody>
</table>