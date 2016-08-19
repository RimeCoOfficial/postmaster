<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>
    <?php echo $list_unsubscribe['list']; ?>

    <span class="pull-right">
        <a href="<?php echo base_url('list-unsubscribe/edit/'.rawurlencode(strtolower($list_unsubscribe['list']))); ?>" class="btn btn-default">Edit</a>
    </span>
</h1>

<p class="lead">
    Created <?php echo $list_unsubscribe['created']; ?> GMT

    <?php
    if ($list_unsubscribe['type'] == 'campaign')
    {
        ?>
        <a href="<?php echo base_url('open/campaign/'.rawurlencode(strtolower($list_unsubscribe['list'])).'/'.md5($list_unsubscribe['created'])); ?>"
            target="_blank">
            <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
        </a>
        <?php
    }
    ?>

    <span class="pull-right">
        <span class="label label-default"><?php echo $list_unsubscribe['type']; ?></span>
    </span>
</p>

<!-- <h2>Recipients</h2> -->

<?php // var_dump($recipient_list); ?>
<?php
if (empty($recipient_list))
{
    ?>
    <p class="lead">No recipient</p>
    <?php
}
else
{
    ?>
    <table class="table table-striped table-condensed">
        <caption>Recent recipients</caption>
        <thead> <tr> <th>#</th> <th>Address</th> <th><samp>metadata_updated, unsubscribed</samp></th> </tr> </thead>
        <tbody>
            <?php
            foreach ($recipient_list as $recipient)
            {
                ?>
                <tr> 
                    <th scope="row">
                        <abbr title="<?php echo $recipient['recipient_id']; ?>">
                            <?php echo $recipient['auto_recipient_id']; ?>
                        </abbr>
                    </th>
                    <td style="word-break: break-all;">
                        <strong><?php echo $recipient['to_name']; ?></strong> <?php echo $recipient['to_email']; ?>
                    </td>
                    <td>
                        <samp>
                            <?php echo $recipient['metadata_updated']; ?>,
                            <?php echo ($recipient['unsubscribed'] == '1000-01-01 00:00:00') ? 'N' : 'Y'; ?>
                        </samp>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>

<br>