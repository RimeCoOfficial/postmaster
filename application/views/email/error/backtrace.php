<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
// function recursive($array, $level = 1) {
//     foreach($array as $key => $value) {
//         //If $value is an array.
//         if(is_array($value)) {
//             //We need to loop through it.
//             recursive($value, $level + 1);
//         } else {
//             //It is not an array, so print it out.
//             echo $key . ": " . $value, '<br>';
//         }
//     }
// }
if (!empty($debug_backtrace))
{
  ?>
  <?php echo e_heading('Debug'); ?>
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
  <?php echo e_heading('Backtrace'); ?>
  <code style="white-space: pre;">
    <ol>
    <?php foreach ($backtrace as $b)
    {
      echo '<li>';
      echo '<b>File:</b> '.$b['file'].'<br>';
      echo '<b>Line:</b> '.$b['line'].'<br>';
      echo '<b>Function:</b> '.$b['function'].'<br>';
      echo '<b>Args:</b> '; print_r($b['args']); echo '<br>';
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
  <?php echo e_heading('Request'); ?>
  <code>
    <?php foreach ($request as $k => $v) echo $k.' => '.$v.'<br>'; ?>
  </code>
  <?php
}
?>

<?php
if (!empty($server))
{
  ?>
  <?php echo e_heading('Server'); ?>
  <code>
    <?php foreach ($server as $k => $v) echo $k.' => '.$v.'<br>'; ?>
  </code>
  <?php
}
?>
