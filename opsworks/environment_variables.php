<?php
/*
 * Environment Variables for application
 */
putenv('FOO=BAR');

putenv('ci_base_url=http://localhost/postmaster');
putenv('ci_proxy_ips=');

putenv('db_hostname=localhost');
putenv('db_username=root');
putenv('db_password=root');

// Debug keys
putenv('aws_account_id=XXXXXXXXXXXX');
putenv('aws_access_key=XXXXXXXXXXXXXXXXXXXX');
putenv('aws_secret_key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
putenv('AWS_PHP_CACHE_DIR=/tmp/aws-cache');

// US East (N. Virginia)        us-east-1
// US West (Oregon)             us-west-2
// US West (N. California)      us-west-1
// EU (Ireland)                 eu-west-1
// EU (Frankfurt)               eu-central-1
// Asia Pacific (Singapore)     ap-southeast-1
// Asia Pacific (Sydney)        ap-southeast-2
// Asia Pacific (Tokyo)         ap-northeast-1
// South America (Sao Paulo)    sa-east-1
putenv('aws_s3_bucket=bucket');
putenv('aws_region=us-east-1');

putenv('ga=UA-XXXXXXXXX-X');

putenv('email_source=postmaster@mail.example.com');

putenv('email_admin=foo@example.com');
putenv('email_debug=bar@example.com');

putenv('api_key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
