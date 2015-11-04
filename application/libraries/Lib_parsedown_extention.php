<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// erusev/parsedown (https://github.com/erusev/parsedown)
// Tutorial: Create Extensions (https://github.com/erusev/parsedown/wiki/Tutorial:-Create-Extensions)
class Lib_parsedown_extention extends Parsedown
{
  function __construct()
  {
    $this->CI =& get_instance();

    // $Parsedown = new Parsedown();
    // echo $Parsedown->text($description);
  }

  // inline formatting: email  MY_html_helper, Lib_parsedown_extention
  protected function blockHeader($Line)
  {
    $Header = parent::blockHeader($Line);

    if ($Header['element']['name'] == 'h1')
      $Header['element']['attributes']['style'] = 'font-size:18px; font-weight: bold; color:#333; line-height: 150%; font-family:Helvetica Neue,Helvetica,sans-serif;';

    return $Header;
  }

  // anchor
  // style="color:#DA2E75" target="_blank"
  protected function inlineLink($Excerpt)
  {
    $Anchor = parent::inlineLink($Excerpt);

    $Anchor['element']['attributes']['style'] = 'color:#DA2E75';
    $Anchor['element']['attributes']['target'] = '_blank';

    return $Anchor;
  }

  // img
  // style="display:inline-block; width:100%; max-width:100%;"
  protected function inlineImage($Excerpt)
  {
    $Image = parent::inlineImage($Excerpt);

    $Image['element']['attributes']['style'] = 'width:100%;';
    $Image['element']['attributes']['data-image'] = 'full';

    return $Image;
  }

  // /**
  //  * The regex which matches an markdown image definition
  //  *
  //  * @var string
  //  */
  // private $markdownImage = "~^!\[.*?\]\(.*?\)$~";
  // /**
  //  * {@inheritdoc}
  //  */
  // protected function paragraph($Line)
  // {
  //   if (1 === preg_match($this->markdownImage, $Line["text"]))
  //   {
  //     return $this->inlineImage($Line['text']);
  //   }
  //   return parent::paragraph($Line);
  // }

  // hr
  // style="margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 1px solid #eee; box-sizing: content-box; height: 0;"
  protected function blockRule($Line)
  {
    $HRule = parent::blockRule($Line);

    if ($HRule['element']['name'] == 'hr')
      $HRule['element']['attributes']['style'] = 'margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 1px solid #eee; box-sizing: content-box; height: 0;';

    return $HRule;
  }
}