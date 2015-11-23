<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
$env_vars = [
  'FOO' => 0,
  'ci_base_url' => 0,
  'ci_proxy_ips' => 0,
  'db_hostname' => 0,
  'db_username' => 0,
  'db_password' => 0,
  'AWS_PHP_CACHE_DIR' => 0,
  'aws_account_id' => 0,
  'aws_access_key' => 0,
  'aws_secret_key' => 1,
  'aws_region' => 0,
  'aws_s3_bucket' => 0,
  'tumblr_client_id' => 0,
  'tumblr_client_secret' => 1,
  'email_source' => 0,
  'email_admin' => 0,
  'email_debug' => 0,
  'email_source' => 0,
  'api_key' => 1,
];
?>

<div class="panel panel-default">
  <div class="panel-heading">Environment Vars</div>

  <table class="table">
    <thead>
      <tr>
        <th>var</th>
        <th>value</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($env_vars as $var => $is_encrypted): ?>
      <tr>
        <th scope="row"><?php echo $var; ?></th>
        <td>
          <?php
          $value = getenv($var);
          if ($is_encrypted) $value = ellipsize($value, strlen($value) * 0.5);
          echo $value;
          ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>