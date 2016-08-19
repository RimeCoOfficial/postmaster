<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
$alert = $this->session->flashdata('alert');
if (!empty($alert))
{
    // success, info, warnaing, danger
    if (empty($alert['type'])) $alert['type'] = 'info';
    ?>
    <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $alert['message']; ?>
    </div>
    <?php
}
?>
