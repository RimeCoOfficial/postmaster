<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('transaction/nav_tab'); ?>

<h1>Label <span class="pull-right label label-default"><?php echo $label['name']; ?></span></h1>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'label', 'value' => $label['name'])); ?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Modify</button>
  </div>
</div>

<?php echo form_close(); ?>

<br>

<h4>Note: Categories are one email recipient can unsubscribe</h4>
<ul>
  <li>It must be unique</li>
  <li>It must contain alpha-numeric, dashes and underscore</li>
  <li>Examples: <code>newsletter</code> <code>notification</code> <code>announcement</code> <code>tip</code> <code>report</code></li>
</ul>
