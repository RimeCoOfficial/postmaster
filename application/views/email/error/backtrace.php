<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
if (!empty($debug_backtrace))
{
  ?>
  <hr>
  <h1><?php echo 'Debug'; ?></h1>
  <code>
    <?php
    print_r($debug_backtrace);
    // print_r(json_encode($debug_backtrace, JSON_PRETTY_PRINT)); ?>
  </code>
  <br>
  <?php
}
?>
<?php
if (!empty($backtrace))
{
  ?>
  <hr>
  <h1><?php echo 'Backtrace'; ?></h1>
  <ol>
    <?php foreach ($backtrace as $b): ?>
    <li>
      <code>
        <b>File:</b> <?php echo $b['file']; ?><br>
        <b>Line:</b> <?php echo $b['line']; ?><br>
        <b>Function:</b> <?php echo $b['function']; ?><br>
        <b>Args:</b> <span style="white-space: pre;"><?php print_r($b['args']); ?></span>
      </code>
      <br>
    </li>
    <?php endforeach; ?>
  </ol>
  <?php
}
?>

<?php
if (!empty($request))
{
  ?>
  <hr>
  <h1><?php echo 'Request'; ?></h1>
  <code>
    <?php foreach ($request as $k => $v) echo '<b>'.$k.':</b> '.$v.'<br>'; ?>
  </code>
  <br>
  <?php
}
?>

<?php
if (!empty($server))
{
  ?>
  <hr>
  <h1><?php echo 'Server'; ?></h1>
  <code>
    <?php foreach ($server as $k => $v) echo '<b>'.$k.':</b> '.$v.'<br>'; ?>
  </code>
  <?php
}
?>
