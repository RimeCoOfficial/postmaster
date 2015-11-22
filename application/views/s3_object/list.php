<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if (!empty($s3_object_list)): ?>

<?php // var_dump($s3_object_list); ?>

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
  Bucket <strong><?php echo $s3_object_list['Name']; ?></strong><br>
  Loaction <?php echo htmlentities($s3_object_list['@metadata']['effectiveUri']); ?><code>/<strong>&lt;key&gt;</strong></code>
</p>

<?php if (!empty($s3_object_list['Contents'])): ?>

<?php // var_dump($s3_object_list['Contents']);
?>

<table class="table">
  <caption>Contents</caption>
  <thead>
    <tr>
      <th>Key</th>
      <th>Archive</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($s3_object_list['Contents'] as $s3_object): ?>
      <?php
      $archived_key = '_archived'.'/';
      $is_archived = starts_with($s3_object['Key'], $archived_key);
      ?>
    <tr>
      <td>
      <!-- <th scope="row"> -->
        <!-- https://s3.amazonaws.com/example-postmaster/inline-image/20151118-081105%20logo-share.png -->
        <strong><?php echo anchor($s3_object_list['@metadata']['effectiveUri'].'/'.$s3_object['Key'], $s3_object['Key'], 'target="_blank" '.($is_archived ? 'class="text-muted"' : '')); ?></strong>
        <br>
        <small><?php echo byte_format($s3_object['Size']); ?>, <?php echo $s3_object['StorageClass']; ?>, created <?php echo date('M d, Y h:i A', strtotime($s3_object['LastModified'])); ?></small>
      </td>
      <!-- </th> -->
      <td><a class="<?php echo $is_archived ? 'text-muted' : 'text-danger'; ?>"
        data-toggle="modal"
        data-target="#s3-object-archive-modal"
        data-key="<?php echo $s3_object['Key']; ?>"
        data-key-encoded="<?php echo urlencode($s3_object['Key']); ?>"
        href="#"><span class="glyphicon glyphicon-<?php echo $is_archived ? 'time' : 'trash'; ?>"></span>
      </a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>

<div class="modal fade" id="s3-object-archive-modal" tabindex="-1" role="dialog" aria-labelledby="s3-object-archive-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="s3-object-archive-modal-label">Archive S3 object</h4>
      </div>
      <div class="modal-body">
        <p>
          Are you sure you want to archive <strong></strong>?
        </p>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-sm-5">
            <a type="button" class="btn btn-danger btn-block" href="#">Archive</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#s3-object-archive-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var key = button.data('key') // Extract info from data-* attributes
    var key_encoded = button.data('key-encoded') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body strong').text(key)
    modal.find('.modal-footer a').attr("href", '<?php echo base_url('s3_object/archive?key='); ?>' + key_encoded)
  });
</script>

<?php endif; ?>