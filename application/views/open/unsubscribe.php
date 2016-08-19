<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Unsubscribed</h1>
<p class="lead">
    You have unsubscribed from <?php echo getenv('app_name') ?> emails.
</p>

<a href="<?php echo getenv('app_base_url'); ?>" class="btn btn-default">
    Continue to <?php echo getenv('app_name') ?> Home
</a>
