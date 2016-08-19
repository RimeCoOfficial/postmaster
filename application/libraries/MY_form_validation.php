<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_form_validation extends CI_form_validation
{
    public function valid_email($str)
    {
        get_instance()->load->helper('email');

        $str = valid_email($str);
        return is_null($str) ? FALSE : $str;
    }
}