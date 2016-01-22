<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  List-Unsubscribe
  <span><a href="<?php echo base_url('list-unsubscribe/create'); ?>" class="btn btn-primary pull-right">New</a></span>
</h1>

<div class="well well-lg">
  <h4>What is it?</h4>
  <p>
    The <a href="http://www.list-unsubscribe.com/" target="_blank" class="alert-link">List-unsubscribe</a> header is an optional chunk of text that email publishers and marketers can include in the header portion of the messages they send. Recipients don't see the header itself, they see an Unsubscribe button they can click if they would like to automatically stop future messages. 
  </p>
</div>

<h4></h4>
<p>
  
</p>

<?php // var_dump($list_unsubscribe); ?>

<?php if (!empty($list_unsubscribe)): ?>
  <div class="list-group">
    <?php foreach ($list_unsubscribe as $list): ?>
      <div class="list-group-item">
        <div class="media">
          <div class="media-body">
            <h5 class="media-heading">
              <?php echo anchor('list-unsubscribe/modify/'.$list['list_id'], $list['list']); ?>
              <small>
                #<?php echo $list['list_id']; ?>
              </small>
            </h5>
          </div>
      
          <div class="media-right">
            <a class="text-danger"
              data-toggle="modal"
              data-target="#list-delete-modal"
              data-list-id="<?php echo $list['list_id']; ?>"
              data-list="<?php echo $list['list']; ?>"
              href="#"><span class="media-object glyphicon glyphicon-trash"></span>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>


<div class="modal fade" id="list-delete-modal" tabindex="-1" role="dialog" aria-labelledby="list-delete-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="list-delete-modal-label">Delete List</h4>
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
  $('#list-delete-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var list = button.data('list') // Extract info from data-* attributes
    var list_id = button.data('list-id') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body strong').text(list)
    modal.find('.modal-footer a').attr("href", '<?php echo base_url('list-unsubscribe/delete'); ?>' + '/' + list_id)
  });
</script>