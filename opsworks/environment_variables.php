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

// US East (N. Virginia)        us-east-1
// US West (Oregon)             us-west-2
// US West (N. California)      us-west-1
// EU (Ireland)                 eu-west-1
// EU (Frankfurt)               eu-central-1
// Asia Pacific (Singapore)     ap-southeast-1
// Asia Pacific (Sydney)        ap-southeast-2
// Asia Pacific (Tokyo)         ap-northeast-1
// South America (Sao Paulo)    sa-east-1
putenv('aws_region=us-west-2');
putenv('aws_s3_bucket=bucket');

putenv('ga=UA-XXXXXXXXX-X');

putenv('tumblr_client_id=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
putenv('tumblr_client_secret=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');

putenv('admin_email_id=joe@example.com');
putenv('debug_email_id=joe@example.com');

putenv('api_key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
