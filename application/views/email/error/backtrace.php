<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
if (!empty($debug_backtrace))
{
  ?>
  <h1><?php echo 'Debug'; ?></h1>
  <code>
    <?php
    print_r($debug_backtrace);
    // print_r(json_encode($debug_backtrace, JSON_PRETTY_PRINT)); ?>
  </code>
  <?php
}
?>
<?php
if (!empty($backtrace))
{
  ?>
  <h1><?php echo 'Backtrace'; ?></h1>
  <code>
    <ol>
    <?php foreach ($backtrace as $b)
    {
      echo '<li>';
      echo '<b>File:</b> '.$b['file'].'<br>';
      echo '<b>Line:</b> '.$b['line'].'<br>';
      echo '<b>Function:</b> '.$b['function'].'<br>';
      echo '<span style="white-space: pre;"><b>Args:</b> '; print_r($b['args']); echo '<br></span>';
      echo '</li>';
      echo '<br>';
    }
    ?>
    </ol>
  </code>
  <?php
}
?>

<?php
if (!empty($request))
{
  ?>
  <h1><?php echo 'Request'; ?></h1>
  <code>
    <?php foreach ($request as $k => $v) echo '<b>'.$k.':</b> '.$v.'<br>'; ?>
  </code>
  <?php
}
?>

<?php
if (!empty($server))
{
  ?>
  <h1><?php echo 'Server'; ?></h1>
  <code>
    <?php foreach ($server as $k => $v) echo '<b>'.$k.':</b> '.$v.'<br>'; ?>
  </code>
  <?php
}
?>
