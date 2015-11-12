<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Text Helpers Class
*
* Extends Text Helpers
*
*/

function app_name()
{
  return get_instance()->config->item('app_name');
}
