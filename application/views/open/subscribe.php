<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Subscribe to <?php echo $list_unsubscribe['list']; ?></h1>
<p class="lead">
    From <?php echo getenv('app_name') ?>
</p>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'full_name', 'value' => NULL)); ?>
<?php $this->view('form/input', array('id' => 'email', 'value' => NULL)); ?>

<div class="row">
    <div class="col-sm-5">
        <button type="submit" class="btn btn-primary btn-block">
            Subscribe
        </button>
    </div>
</div>

<?php echo form_close(); ?>
