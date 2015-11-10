<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h2>Upload Image</h2>

<?php
if (!empty($s3_object_url))
{
  ?>
  <div class="thumbnail">
    <img class="img-responsive" src="<?php echo $s3_object_url; ?>">
  </div>

  <pre><?php echo $s3_object_url; ?></pre>
  <?php
}
else
{
  ?>

  <?php echo form_open_multipart(uri_string()); ?>

  <?php $this->view('form/input', array('id' => 'upload_image', 'value' => NULL)); ?>

  <div class="row">
    <div class="col-sm-5">
      <button type="submit" class="btn btn-primary btn-block">Upload</button>
    </div>
  </div>

  <?php echo form_close(); ?>

  <?php
}
?>
