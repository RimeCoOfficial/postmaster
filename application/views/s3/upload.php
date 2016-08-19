<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
    Upload S3 object

    <span class="pull-right">
        <span class="label label-default"><?php echo $prefix; ?></span>
    </span>
</h1>

<?php
if (!empty($s3_object_url))
{
    ?>
    <a href="<?php echo $s3_object_url; ?>" target="_blank">
        <div class="thumbnail">
            <img class="img-responsive" src="<?php echo $s3_object_url; ?>">
        </div>
    </a>

    <pre><?php echo $s3_object_url; ?></pre>
    <?php
}
else
{
    ?>
    
    <?php echo form_open_multipart(uri_string()); ?>

    <?php $this->view('form/input', array('id' => 'upload_s3_object', 'value' => NULL)); ?>

    <div class="row">
        <div class="col-sm-5">
            <button type="submit" class="btn btn-primary btn-block">Upload</button>
        </div>
    </div>

    <?php echo form_close(); ?>

    <?php
}
?>

<br>