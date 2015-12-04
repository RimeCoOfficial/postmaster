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

      // if ($message['published'] == '1000-01-01 00:00:00' AND $message['archived'] == '1000-01-01 00:00:00')
      // {
      //   // camapign and autoresponder drafting stage
      //   $is_link_gray = '';
      // }
      // elseif ($message['published'] == '1000-01-01 00:00:00' AND $message['archived'] != '1000-01-01 00:00:00')
      // {
      //   // not published but archived ???
      //   // => not published = drafing stage
      //   // => campaign and autoresponder
      //   // => transactions are always published
      //   // = draft is deleted
      //   // restore-able
      //   $is_link_gray = 'list-group-item-warning';
      // }
      // elseif ($message['published'] != '1000-01-01 00:00:00' AND $message['archived'] == '1000-01-01 00:00:00')
      // {
      //   // published and not archived = good to go!
      //   // active transaction
      //   // campaign in progress
      //   // autoresponder in progress
      //   $is_link_gray = 'list-group-item-info';
      // }
      // elseif ($message['published'] != '1000-01-01 00:00:00' AND $message['archived'] != '1000-01-01 00:00:00')
      // {
      //   // published and archived
      //   // campaign is finished cant be not restored
      //   // autoresponder not required can be restored
      //   // transactions not required can be restored
        
      //   $is_link_gray = '';

      //   if (date('Y-m-d H:m:s') < $message['archived'])
      //   {}
      // }
      
      // $is_link_gray = $message['archived'] != '1000-01-01 00:00:00';
      // var_dump($is_link_gray);
      ?>
      <a class="list-group-item" href="<?php echo base_url('message/show/'.$message['message_id']); ?>" target="_blank">

        <div class="media">
          <div class="media-body">
            <h5 class="media-heading">
              <?php echo $message['subject']; ?>
              <small>
                #<?php echo $message['message_id']; ?>
                <span class="text-uppercase"><?php echo $message['owner']; ?></span>
                <?php echo $message['reply_to_name']; ?>
                <?php echo $message['reply_to_email']; ?>
                <?php if (!empty($message['tumblr_post_id'])) echo $message['tumblr_post_id']; ?>
                <?php echo date('M d, Y h:i A', strtotime($message['created'])); ?>
              </small>
            </h5>
          </div>
        </div>

      </a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>