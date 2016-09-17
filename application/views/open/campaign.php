<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1><?php echo $list_unsubscribe['list']; ?></h1>
<p class="lead">
    From <?php echo getenv('app_name') ?>
</p>

<?php
$list = rawurlencode(strtolower($list_unsubscribe['list']));
if (empty($subscribe_uri)) $subscribe_uri = base_url('open/subscribe/'.$list);
else
{
    $subscribe_uri = getenv('app_base_url').'/'.$subscribe_uri;
    $subscribe_uri .= 'list='.$list;
}
?>

<a href="<?php echo $subscribe_uri; ?>" class="btn btn-default">
    Subscribe to mailing list
</a>

<br>
<br>

<?php
if (empty($message_list))
{
    ?>
    <p class="lead">Nothing yet published!</p>
    <?php
}
else
{
    ?>
    <div class="list-group">
        <?php
        foreach ($message_list as $message)
        {
            ?>
            <a class="list-group-item" href="<?php echo base_url('open/message/'.$message['message_id'].'/html'); ?>">
                <strong><?php echo $message['subject']; ?></strong>

                <span class="pull-right small">
                    <samp><?php echo date('M d, Y', strtotime($message['archived'])); ?></samp>
                </span>
            </a>
            <?php
        }
        ?>
    </div>
    <?php
}
?>
