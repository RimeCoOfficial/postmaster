<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if (!empty($s3_object_list)): ?>

  <?php // var_dump($s3_object_list); ?>

  <?php
  $prefix = $s3_object_list['Prefix'];

  $s3_url = $s3_object_list['@metadata']['effectiveUri'];
  $s3_url = parse_url($s3_url);
  $s3_url = $s3_url['scheme'].'://'.$s3_url['host'].$s3_url['path'];
  ?>

  <h1>
    S3 objects
    <span class="pull-right">
      <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Upload
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
          <li><a href="<?php echo base_url('s3-object/upload/inline-image'); ?>">Picture inline</a></li>
          <li><a href="<?php echo base_url('s3-object/upload/file'); ?>">File as attachment</a></li>
          <li><a href="<?php echo base_url('s3-object/upload/import'); ?>">Import</a></li>
        </ul>
      </div>
    </span>
  </h1>

  <p>
    Bucket <strong><?php echo $s3_object_list['Name']; ?></strong><br>
    Loaction <?php echo htmlentities($s3_url); ?><code>/<strong>&lt;key&gt;</strong></code>
  </p>

  <ol class="breadcrumb">
    <?php if (!empty($s3_object_list['Prefix'])): ?>
      <li><?php echo anchor('s3-object', $s3_object_list['Name']); ?></li>
      <?php // var_dump($s3_object_list['Prefix']); ?>
      <?php
      $prefix_list = explode('/', $prefix);

      if (!empty($prefix_list))
      {
        $prefix_key = '';
        for ($i = 0; $i <= count($prefix_list) - 2; $i++):
          $name = $prefix_list[ $i ];

          if ($i == (count($prefix_list) - 2)) break;

          // if (empty($name)) continue;
          $prefix_key .= $name.'/';
          ?>
          <li><?php echo anchor('s3-object/index?prefix='.urlencode($prefix_key), $name); ?></li>
        <?php endfor; ?>

        <li class="active"><?php echo $name; ?></li>
        <?php
      }
      ?>
    <?php else: ?>
      <li class="active"><?php echo $s3_object_list['Name']; ?></li>
    <?php endif; ?>
  </ol>

  <div class="list-group">
    <?php if (!empty($s3_object_list['CommonPrefixes'])): ?>
      <?php foreach ($s3_object_list['CommonPrefixes'] as $common_prefix): ?>
        <a class="list-group-item" href="<?php echo base_url('s3-object/index?prefix='.urlencode($common_prefix['Prefix'])); ?>">

          <div class="media">
            <div class="media-left">
              <span class="media-object glyphicon glyphicon-folder-close"></span>
            </div>
            <div class="media-body">
              <h5 class="media-heading"><?php echo s3_key_name($common_prefix['Prefix'], $prefix); ?></h5>
            </div>
          </div>
          
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  
    <?php if (!empty($s3_object_list['Contents'])): ?>
      <?php foreach ($s3_object_list['Contents'] as $s3_object): ?>
        <a class="list-group-item" href="<?php echo $s3_url.'/'.$s3_object['Key']; ?>" target="_blank">

          <div class="media">
            <div class="media-body">
              <h5 class="media-heading">
                <?php echo s3_key_name($s3_object['Key'], $prefix); ?>
                <small>
                  <?php echo byte_format($s3_object['Size']); ?>,
                  <?php echo $s3_object['StorageClass']; ?>,
                  created <?php echo date('M d, Y h:i A', strtotime($s3_object['LastModified'])); ?>
                </small>
              </h5>
            </div>
          </div>

        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

<?php endif; ?>
