<?php
/*
 * Environment Variables for application
 */
putenv('FOO=BAR');

putenv('db_hostname=localhost');
putenv('db_username=root');
putenv('db_password=root');

// Debug keys
putenv('aws_account_id=012345678901');
putenv('aws_access_key=ABCDEFGHIJKLMNOPQWEQ');
putenv('aws_secret_key=skudhfjk8WN1J2/FHskduUEHFNEIUSDBI2ani+A0');

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

putenv('ga=UA-12345678-1');

putenv('tumblr_client_id=auwhajw2JHGWJHB2M2MJSFNSJEJBJ2BJ12aj21JDKBJKJW2jBJ');
putenv('tumblr_client_secret=EUjseheuiw182bjBJBWKJBWJBJAy3blfnlseifkbWBLBWJbbfe');