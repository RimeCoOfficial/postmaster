<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Etechnika\IdnaConvert\IdnaConvert as IdnaConvert;
// IdnaConvert::encodeString( 'żółw.pl' ); // prints 'xn--w-uga1v8h.pl'
// IdnaConvert::decodeString( 'xn--w-uga1v8h.pl' ); // prints 'żółw.pl'

class Lib_idna_convert
{
  // if (function_exists('idn_to_ascii')) // PECL Library idn_to_ascii
  // {
  //   $str = idn_to_ascii($str);
  // }
  function encode($str) { return IdnaConvert::encodeString($str); }
  function decode($str) { return IdnaConvert::decodeString($str); }
}
