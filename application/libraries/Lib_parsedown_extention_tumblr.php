<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// erusev/parsedown (https://github.com/erusev/parsedown)
// Tutorial: Create Extensions (https://github.com/erusev/parsedown/wiki/Tutorial:-Create-Extensions)
class Lib_parsedown_extention_tumblr extends Parsedown
{
  function __construct()
  {
    $this->CI =& get_instance();

    // $Parsedown = new Parsedown();
    // echo $Parsedown->text($description);
  }

  // erusev/parsedown: #180 img wrapped in p https://github.com/erusev/parsedown/issues/180
  // @apfelbox https://gist.github.com/fxck/d65255218de3611df3cd

  /**
   * Adjusted parser to render paragraphs which only contain a single image without the paragraph.
   *
   * So instead
   * <p><img ...></p>
   *
   * it just renders
   * <img ...>
   */

  /**
   * The regex which matches an markdown image definition
   *
   * @var string
   */
  private $markdownImage = "~^!\[.*?\]\(.*?\)$~";

  /**
   * {@inheritdoc}
   */
  protected function paragraph($Line)
  {
    if (1 === preg_match($this->markdownImage, $Line["text"]))
    {
      // <figure class="tmblr-full"><img></figure>
      $Block = array(
        'element' => array(
          'name' => 'figure',
          'text' => $Line['text'],
          'handler' => 'line',
          'class' => 'tmblr-full',
        ),
      );

      return $Block;
    }
    
    return parent::paragraph($Line);
  }

  // img
  // <figure class="tmblr-full"><img></figure>
  // protected function element(array $Element)
  // {
  //   $str = parent::element($Element);
  //   if ($Element['name'] == 'img')
  //   {
  //     // var_dump($Element, $str);
  //     $str = '<figure class="tmblr-full">'.$str.'</figure>';
  //   }
  //   return $str;
  // }
}