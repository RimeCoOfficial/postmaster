<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Uploads <span><a href="<?php echo base_url('upload/go'); ?>" class="btn btn-primary pull-right">Create</a></span></h1>

<?php // var_dump($upload_list); ?>

<?php if (!empty($upload_list)): ?>
<table class="table">
  <caption>
    Bucket <strong><?php echo $aws_config['s3_bucket']; ?></strong><br>
    https://s3-<strong><?php echo $aws_config['region']; ?></strong>.amazonaws.com/<strong><?php echo $aws_config['s3_bucket']; ?></strong>/
  </caption>
  <thead>
    <tr>
      <th>#</th>
      <th>S3 key</th>
      <!-- <th>Delete</th> -->
    </tr>
  </thead>

  <tbody>
    <?php foreach ($upload_list as $upload): ?>
    <tr>    
      <th scope="row">
        <small>
          <?php if ($upload['is_image']): ?>
          <span class="glyphicon glyphicon-picture"></span>
          <?php else: ?>
          <span class="glyphicon glyphicon-file"></span>
          <?php endif; ?>
        </small>
      </th>

      <td>
        <!-- https://s3-us-west-2.amazonaws.com/rime-mail/inline-image/20151118-081105%20logo-share.png -->
        <strong><?php echo anchor('https://s3-'.$aws_config['region'].'.amazonaws.com/'.$aws_config['s3_bucket'].'/'.$upload['s3_key'], $upload['s3_key'], 'target="_blank"'); ?></strong>
        <br>
        <small><?php echo $upload['file_size']; ?> KB, <?php echo $upload['file_type']; ?>, created <?php echo date('M d, Y h:i A', strtotime($upload['created'])); ?></small>
      </td>
      <!-- 
      <td><a href="#"
        data-toggle="modal"
        data-target="#upload-delete-modal"
        data-s3-key="<?php echo $upload['s3_key']; ?>"
        href="#"><span class="glyphicon glyphicon-trash"></span>
      </a></td>
      -->
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>


<div class="modal fade" id="upload-delete-modal" tabindex="-1" role="dialog" aria-labelledby="upload-delete-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="upload-delete-modal-label">Delete upload</h4>
      </div>
      <div class="modal-body">
        <p>
          Are you sure you want to delete <strong></strong>?
        </p>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-sm-5">
            <a type="button" class="btn btn-danger btn-block" href="#">Delete</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#upload-delete-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var s3_key = button.data('s3-key') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body strong').text(s3_key)
    modal.find('.modal-footer a').attr("href", '<?php echo base_url('upload/delete'); ?>' + '/' + s3_key)
  });
</script>