<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
  List-unsubscribe
  
  <span class="pull-right">
    <a href="<?php echo base_url('list-unsubscribe/create'); ?>" class="btn btn-primary">New</a>
  </span>
</h1>

<div class="well">
  <h5>What is it?</h5>
  <p>
    The <a href="http://www.list-unsubscribe.com/" target="_blank" class="alert-link">List-unsubscribe</a> header is an optional chunk of text that email publishers and marketers can include in the header portion of the messages they send. Recipients don't see the header itself, they see an Unsubscribe button they can click if they would like to automatically stop future messages. 
  </p>
</div>

<?php // var_dump($list_unsubscribe); ?>

<?php if (!empty($list_unsubscribe)): ?>
  <div class="list-group">
    <?php foreach ($list_unsubscribe as $list): ?>
      <div class="list-group-item">
        <div class="media">
          <div class="media-body">
            <div class="media-heading lead">
              <!-- <?php echo $list['list_id']; ?> -->
              <?php echo anchor('list-unsubscribe/recipients/'.rawurlencode(strtolower($list['list'])), $list['list']); ?>
            </div>
          </div>

          <div class="media-right">
            <!-- <a href="<?php echo base_url('list-unsubscribe?filter=list_type:'.$list['type']); ?>"> -->
              <span class="media-object label label-default">
                <?php echo $list['type']; ?>
              </span>
            <!-- </a> -->
          </div>
          
          <div class="media-right">
            <a href="<?php echo base_url('message/create/'.rawurlencode(strtolower($list['list']))); ?>">
              <span class="media-object glyphicon glyphicon-plus"></span>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
