<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  S3 objects
  <span class="pull-right">
    <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Upload
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
        <li><a href="<?php echo base_url('s3-object/upload/inline-image'); ?>">Inline image</a></li>
        <li><a href="<?php echo base_url('s3-object/upload/attachment'); ?>">Attachment</a></li>
        <li><a href="<?php echo base_url('s3-object/upload/import'); ?>">Import</a></li>
      </ul>
    </div>
  </span>
</h1>

<p>
  Bucket <strong><?php echo $aws_config['s3_bucket']; ?></strong><br>
  <code>https://s3.amazonaws.com/<strong><?php echo $aws_config['s3_bucket']; ?></strong>/&lt;S3_key&gt;</code>
</p>

<?php if (!empty($s3_object_list)): ?>
<table class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>S3 key</th>
      <!-- <th>Delete</th> -->
    </tr>
  </thead>

  <tbody>
    <?php foreach ($s3_object_list as $s3_object): ?>
    <tr>    
      <th scope="row">
        <small>
          <?php if ($s3_object['is_image']): ?>
          <span class="glyphicon glyphicon-picture"></span>
          <?php else: ?>
          <span class="glyphicon glyphicon-file"></span>
          <?php endif; ?>
        </small>
      </th>

      <td>
        <!-- https://s3.amazonaws.com/example-postmaster/inline-image/20151118-081105%20logo-share.png -->
        <strong><?php echo anchor('https://s3.amazonaws.com/'.$aws_config['s3_bucket'].'/'.$s3_object['s3_key'], $s3_object['s3_key'], 'target="_blank"'); ?></strong>
        <br>
        <small><?php echo $s3_object['file_size']; ?> KB, <?php echo $s3_object['file_type']; ?>, created <?php echo date('M d, Y h:i A', strtotime($s3_object['created'])); ?></small>
      </td>
      <!-- <td><a href="#"
        data-toggle="modal"
        data-target="#s3_object-delete-modal"
        data-s3-key="<?php echo $s3_object['s3_key']; ?>"
        data-s3-key-encoded="<?php echo urlencode($s3_object['s3_key']); ?>"
        href="#"><span class="glyphicon glyphicon-trash"></span>
      </a></td> -->
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>


<div class="modal fade" id="s3_object-delete-modal" tabindex="-1" role="dialog" aria-labelledby="s3_object-delete-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="s3_object-delete-modal-label">Delete s3_object</h4>
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
  $('#s3_object-delete-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var s3_key = button.data('s3-key') // Extract info from data-* attributes
    var s3_key_encoded = button.data('s3-key-encoded') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body strong').text(s3_key)
    modal.find('.modal-footer a').attr("href", '<?php echo base_url('s3_object/delete?s3_key='); ?>' + s3_key_encoded)
  });
</script>