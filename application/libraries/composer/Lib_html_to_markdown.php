<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use League\HTMLToMarkdown\HtmlConverter;

class Lib_html_to_markdown
{
  private $converter = NULL;

  public function __construct()
  {
    $this->converter = new HtmlConverter();
  }

  public function convert($html)
  {
    $markdown = $this->converter->convert($html);
    return $markdown;
  }
}