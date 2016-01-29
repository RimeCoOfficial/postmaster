<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Messages</h1>

<?php // var_dump($list); ?>

<?php if (empty($list)): ?>
  <p class="lead text-muted">No message found</p>
<?php else: ?>
  <div class="list-group">
    <?php foreach ($list as $message): ?>
      <?php
      // active list-group-item-success list-group-item-info list-group-item-warning list-group-item-danger
      // $is_link_gray = '';

      // if ($message['published_tds'] == '1000-01-01 00:00:00' AND $message['archived'] == '1000-01-01 00:00:00')
      // {
      //   // camapign and autoresponder drafting stage
      //   $is_link_gray = '';
      // }
      // elseif ($message['published_tds'] == '1000-01-01 00:00:00' AND $message['archived'] != '1000-01-01 00:00:00')
      // {
      //   // not published_tds but archived ???
      //   // => not published_tds = drafing stage
      //   // => campaign and autoresponder
      //   // => transactionals are always published_tds
      //   // = draft is deleted
      //   // restore-able
      //   $is_link_gray = 'list-group-item-warning';
      // }
      // elseif ($message['published_tds'] != '1000-01-01 00:00:00' AND $message['archived'] == '1000-01-01 00:00:00')
      // {
      //   // published_tds and not archived = good to go!
      //   // active transactional
      //   // campaign in progress
      //   // autoresponder in progress
      //   $is_link_gray = 'list-group-item-info';
      // }
      // elseif ($message['published_tds'] != '1000-01-01 00:00:00' AND $message['archived'] != '1000-01-01 00:00:00')
      // {
      //   // published_tds and archived
      //   // campaign is finished cant be not restored
      //   // autoresponder not required can be restored
      //   // transactionals not required can be restored
        
      //   $is_link_gray = '';

      //   if (date('Y-m-d H:m:s') < $message['archived'])
      //   {}
      // }
      
      // $is_link_gray = $message['archived'] != '1000-01-01 00:00:00';
      // var_dump($is_link_gray);
      ?>
      <!--  -->

      <div class="list-group-item">
        <div class="media">
          <div class="media-body">
            <h5 class="media-heading">
              <a  href="<?php echo base_url('message/view/'.$message['message_id']); ?>">
                <?php echo $message['subject']; ?>
              </a>
              <small>
                #<?php echo $message['message_id']; ?>
                
                <span class="text-uppercase"><?php echo anchor('message/view/list-unsubscribe/'.$message['list'], $message['list']); ?></span>

                <?php echo $message['reply_to_name']; ?>
                <?php echo $message['reply_to_email']; ?>
                <?php echo date('M d, Y h:i A', strtotime($message['created'])); ?>
              </small>

              <span class="pull-right">
                <a href="<?php echo base_url('message/view/type/'.$message['type']); ?>">
                  <span class="label label-default">
                    <?php echo $message['type']; ?>
                  </span>
                </a>
              </span>
            </h5>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
