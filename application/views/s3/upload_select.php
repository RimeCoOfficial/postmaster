<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Upload S3 object</h1>

<div class="list-group">
    <?php foreach ($prefixes as $prefix => $config): ?>
        <a href="<?php echo base_url('s3/upload/'.$prefix); ?>" class="list-group-item">

            <div class="media">
                <!-- <div class="media-left">
                    <span class="lead media-object glyphicon <?php echo $config['icon']; ?>">
                    </span>
                </div> -->
                <div class="media-body">
                    <h4 class="media-heading">
                        <?php echo $config['title']; ?><br>
                        <small class="text-uppercase"><?php echo $prefix; ?></small>
                    </h4>
                    <ul class="list-inline">
                        <?php foreach ($config['upload'] as $key => $value): ?>
                            <li class="text-muted">
                                <strong><?php echo $key; ?></strong>
                                <samp><?php print_r($value); ?></samp>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        </a>
    <?php endforeach; ?>
</div>
