<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Modal -->
<div class="modal fade" id="sendTestModal" tabindex="-1" role="dialog" aria-labelledby="sendTestModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sendTestModalLabel">Send test mail</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open('message/send-test/'.$message['message_id']); ?>

        <?php $this->view('form/input', array('id' => 'email', 'value' => NULL)); ?>

        <div class="row">
          <div class="col-sm-5">
            <button type="submit" class="btn btn-primary btn-block">Send</button>
          </div>
        </div>

        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
