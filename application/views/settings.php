<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
$env_var_is_hidden = [
  'FOO'               => FALSE,
  'ci_base_url'       => FALSE,
  'ci_proxy_ips'      => FALSE,
  'db_hostname'       => FALSE,
  'db_username'       => FALSE,
  'db_password'       => FALSE,
  'AWS_PHP_CACHE_DIR' => FALSE,
  'aws_account_id'    => FALSE,
  'aws_access_key'    => FALSE,
  'aws_secret_key'    => TRUE,
  'aws_region'        => FALSE,
  'aws_s3_bucket'     => FALSE,
  'ga'                => FALSE,
  'email_source'      => FALSE,
  'email_admin'       => FALSE,
  'email_debug'       => FALSE,
  'email_source'      => FALSE,
  'api_key'           => TRUE,
];
?>

<?php
// ob_start();
// phpinfo(INFO_ENVIRONMENT);
// $variable = ob_get_contents();
// ob_get_clean();
?>

<!-- <div class="embed-responsive embed-responsive-4by3">
  <iframe src="data:text/html;charset=utf-8,<?php echo htmlentities($variable); ?>"></iframe>
</div>
<br>
<br> -->

<div class="panel panel-default">
  <div class="panel-heading">Environment Vars</div>

  <table class="table">
    <thead>
      <tr>
        <th>Variable</th>
        <th>Value</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($env_var_is_hidden as $env_var => $is_hidden): ?>
      <tr>
        <th scope="row"><strong><?php echo $env_var; ?></strong></th>
        <td>
          <code>
            <?php
            $value = getenv($env_var);
            if ($is_hidden)
            {
              echo substr($value, 0, 4);
              echo '<small>';
              $len = strlen($value);

              // ✱ HEAVY ASTERISK: Zapf Dingbats
              // ✕ MULTIPLICATION X
              // • BULLET
              // ● BLACK CIRCLE
              // ○ WHITE CIRCLE
              for ($i = 4; $i < $len; $i++) echo '•';
              echo '<small>';
            }
            else echo $value;
            ?>
          </code>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

