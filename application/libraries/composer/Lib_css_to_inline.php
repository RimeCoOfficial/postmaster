<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class Lib_css_to_inline
{
  private $cssToInlineStyles = NULL;

  public function __construct()
  {
    $this->cssToInlineStyles = new CssToInlineStyles();
  }

  public function convert($html, $css = NULL)
  {
    if (is_null($css))
    {
      libxml_use_internal_errors(true);
      $doc = new DOMDocument();
      $doc->loadHTML($html);

      $links = $doc->getElementsByTagName('link');
      foreach ($links as $link)
      {
        if ($link->getAttribute('rel') == 'stylesheet')
        {
          $stylesheet_href = $link->getAttribute('href');
          if (!empty($stylesheet_href))
          {
            // $css = file_get_contents('https://rimeofficial.github.io/asset/css/email.css');
            $css = file_get_contents($stylesheet_href);
            break;
          }
        }
      }
    }

    // Or use inline-styles blocks from the HTML as CSS
    $this->cssToInlineStyles->setHTML($html);
    $this->cssToInlineStyles->setCSS($css);
    // $this->cssToInlineStyles->setUseInlineStylesBlock(TRUE);
    // $this->cssToInlineStyles->setCleanup(TRUE);
    $html = $this->cssToInlineStyles->convert();
    return $html;
  }
}
