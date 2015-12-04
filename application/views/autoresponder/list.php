<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Messages <span><a href="<?php echo base_url('autoresponder/message/create'); ?>" class="btn btn-primary pull-right">Create</a></span></h1>

<?php // var_dump($list); ?>

<?php if (!empty($list)): ?>
  <div class="list-group">
    <?php foreach ($list as $key => $transaction): ?>
      <?php
      $is_link_gray = $transaction['archived'] != '1000-01-01 00:00:00';
      ?>
      <div class="list-group-item">
        <div class="media">
          <div class="media-body">
            <h5 class="media-heading">
              <?php echo anchor('transaction/message/modify/'.$transaction['message_id'], $transaction['subject'], $is_link_gray ? 'class="text-muted"' : ''); ?>
              <small>
                #<?php echo $transaction['message_id']; ?>
                <?php echo $transaction['reply_to_name']; ?>
                <?php echo $transaction['reply_to_email']; ?>
              </small>

              <?php if (!empty($transaction['label'])): ?>
                <span class="pull-right label label-default">
                  <?php echo $transaction['label']; ?>
                </span>
              <?php endif; ?>
            </h5>
          </div>
          
          <!-- 
          <div class="media-right">
            <a class="text-danger"
              data-toggle="modal"
              data-target="#transaction-delete-modal"
              data-message-id="<?php echo $transaction['message_id']; ?>"
              data-transaction-subject="<?php echo $transaction['subject']; ?>"
              href="#"><span class="media-object glyphicon glyphicon-trash"></span>
            </a>
          </div>
           -->
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <p class="lead text-muted">No message found</p>
<?php endif; ?>

<div class="modal fade" id="transaction-delete-modal" tabindex="-1" role="dialog" aria-labelledby="transaction-delete-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="transaction-delete-modal-label">Delete Transaction</h4>
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
  $('#transaction-delete-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var transaction_subject = button.data('transaction-subject') // Extract info from data-* attributes
    var message_id = button.data('message-id') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body strong').text(transaction_subject)
    modal.find('.modal-footer a').attr("href", '<?php echo base_url('transaction/home/delete'); ?>' + '/' + message_id)
  });
</script>