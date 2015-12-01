<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_html_to_markdown
{
  private $converter = NULL;

  public function __construct()
  {
    $this->converter = new League\HTMLToMarkdown\HtmlConverter();
  }

  public function convert($html) { return $this->converter->convert($html); }
}

// class Lib_html_to_markdown
// {
//   private $converter;

//   public function __construct()
//   {
//     $this->CI =& get_instance();
//     $this->converter = new Markdownify\ConverterExtra;
//   }

//   public function convert($html) { return $this->converter->parseString($html); }
// }