<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function set_dropdown_options($id, $values = [])
{
    $CI =& get_instance();

    $CI->config->load('form_element', TRUE);
    $config = $CI->config->item('form_element');

    $config[ $id ]['rules'] = str_replace('in_list[]', 'in_list['.implode(',', array_keys($values)).']', $config[ $id ]['rules']);
    $config[ $id ]['options'] = $values;
    $CI->config->set_item('form_element', $config);
}