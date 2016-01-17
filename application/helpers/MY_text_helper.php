<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Text Helpers Class
*
* Extends Text Helpers
*
*/

function html_to_text($html)
{
  // $dom = HtmlDomParser::str_get_html($html);
  // if (!is_null($html_dom = $dom->find('div[id=text-area]', 0)))
  // {
  //   $html = $html_dom->innertext;
  // }

  $text = strip_tags($html);

  // http://stackoverflow.com/a/2368546
  $text = preg_replace('!\s+!', ' ', $text); // or '/\s+/'

  $text = trim($text);

  return $text;
}