<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use zz\Html\HTMLMinify;

class Lib_html_minifier
{
    public function process($str) { return HTMLMinify::minify($str); }
}
