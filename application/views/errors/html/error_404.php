<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$base_url = config_item('base_url');
$asset_url = config_item('asset_url');

?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>404 Page Not Found</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $asset_url.('stylesheets/main.min.css'); ?>">
    </head>
    <body>
        <div class="container container-slim">
            <h1><?php echo $heading; ?></h1>
            <?php echo $message; ?>
        </div>
    </body>
</html>