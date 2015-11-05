<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Stats</h1>

<table class="table">
  <caption>Feedback</caption>
  <thead>
    <tr>
      <th>State</th>
      <th>Type</th>
      <th>Timestamp</th>
      <th>Count</th>
    </tr>
  </thead>

  <tbody>
    <?php
    $total = 0;
    foreach ($feedback as $s)
    {
      $total += $s['count'];
      ?>
      <tr>
        <th scope="row"><?php echo $s['state']; ?></th>
        <td><?php echo $s['type']; ?></td>
        <td><?php echo $s['timestamp']; ?></td>
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
<!-- 
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
    if (FALSE)
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
 -->