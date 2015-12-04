<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Upload object</h1>

<div class="list-group">
  <?php foreach ($prefixes as $prefix => $config): ?>
    <a href="<?php echo base_url('s3-object/upload/'.$prefix); ?>" class="list-group-item">

      <div class="media">
        <!-- <div class="media-left">
          <span class="lead media-object glyphicon <?php echo $config['icon']; ?>">
          </span>
        </div> -->
        <div class="media-body">
          <h3 class="media-heading">
            <span class="text-capitalize"><?php echo $config['title']; ?></span>
            <!-- <small><?php echo $config['description']; ?></small> -->
            <span class="pull-right label label-default"><?php echo $prefix; ?></span>
          </h3>
          <dl class="dl-horizontal">
            <?php foreach ($config['upload'] as $key => $value): ?>
            <dt><?php echo str_replace('_', ' ', $key); ?></dt>
            <dd><?php echo $value; ?></dd>
            <?php endforeach; ?>
          </dl>
        </div>
      </div>

    </a>
  <?php endforeach; ?>
</div>