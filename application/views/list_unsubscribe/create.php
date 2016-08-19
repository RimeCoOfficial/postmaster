<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>New List-unsubscribe</h1>

<?php echo form_open(uri_string()); ?>

<?php $this->view('form/input', array('id' => 'list', 'value' => NULL)); ?>
<?php $this->view('form/dropdown', array('id' => 'type', 'value' => NULL)); ?>

<div class="row">
    <div class="col-sm-5">
        <button type="submit" class="btn btn-primary btn-block">Create</button>
    </div>
</div>

<?php echo form_close(); ?>

<br>

<dl>
    <dt>Note: List-unsubscribe are one email recipient can unsubscribe</dt>
    <dd>Type can <strong>not</strong> be changed later</dd>
    <dd>Examples: <code>Newsletter</code> <code>Notification</code> <code>Announcement</code> <code>Request sign-up</code></dd>
</dl>
