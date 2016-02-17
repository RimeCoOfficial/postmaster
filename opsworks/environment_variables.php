<?php
/*
 * Environment Variables for application
 */
putenv('FOO=BAR');

putenv('ci_cache_dir=/Users/suvozit/Sites/postmaster/application/cache');
putenv('ci_base_url=http://localhost/postmaster');
putenv('ci_proxy_ips=');

putenv('db_hostname=localhost');
putenv('db_username=root');
putenv('db_password=root');

// Debug keys
putenv('AWS_PHP_CACHE_DIR=/Users/suvozit/Sites/postmaster/application/cache/aws');
putenv('aws_account_id=111111111111');
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
putenv('aws_region=xx-xxxx-1');
putenv('aws_s3_bucket=bucket');

putenv('ga=UA-XXXXXXXXX-1');

putenv('email_source=postmaster@example.com');

putenv('email_admin=founders@example.com');
putenv('email_debug=debug-postmaster@example.com');

putenv('api_key=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');

putenv('app_name=Example');
putenv('app_base_url=http://localhost/example');
putenv('app_unsubscribe_uri=');
// for custom unsubscribe page, apend a query to uri with a question mark (?)
//    /email/unsubscribe?
//    /email/unsubscribe?archive_id=XXXX&unsubscribe_key=YYYY
// putenv('app_unsubscribe_uri=/email/unsubscribe?');
