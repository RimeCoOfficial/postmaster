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
putenv('AWS_PHP_CACHE_DIR=/tmp/aws-cache');
putenv('aws_account_id=667785696107');
putenv('aws_access_key=AKIAJQ42S46BKBVQ66EQ');
putenv('aws_secret_key=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');

// US East (N. Virginia)        us-east-1
// US West (Oregon)             us-west-2
// US West (N. California)      us-west-1
// EU (Ireland)                 eu-west-1
// EU (Frankfurt)               eu-central-1
// Asia Pacific (Singapore)     ap-southeast-1
// Asia Pacific (Sydney)        ap-southeast-2
// Asia Pacific (Tokyo)         ap-northeast-1
// South America (Sao Paulo)    sa-east-1
putenv('aws_region=us-east-1');
putenv('aws_s3_bucket=rime-mail');

putenv('ga=UA-XXXXXXXXX-X');

putenv('email_source=postmaster@rime.co');

putenv('email_admin=suvozit@rime.co');
putenv('email_debug=debug-postmaster@rime.co');

putenv('api_key=ce1bb981e00cacca2d248261a0a4a530');
