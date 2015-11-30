<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_markdown
{
  private $converter;

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->converter = new Markdownify\ConverterExtra;
  }

  public function convert($html) { return $this->converter->parseString($html); }
}