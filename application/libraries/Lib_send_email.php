<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_send_email
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
  }
  
  /**
   * Get error message.
   * Can be invoked after any failed operation.
   *
   * @return  string
   */
  function get_error_message()
  {
    return $this->error;
  }

  function direct($to, $subject, $message_html, $message_txt)
  {
    $this->CI->load->library('composer/lib_aws');
    $ses_client = $this->CI->lib_aws->get_ses();

    $result = $ses_client->sendEmail([
      'Destination' => [
        'ToAddresses' => [$to],
      ],
      'Message' => [
        'Body' => [
          'Html' => ['Data' => $message_html],
          'Text' => ['Data' => $message_txt],
        ],
        'Subject' => ['Data' => $subject],
      ],
      'Source' => getenv('source_email'),
    ]);

    return $result['MessageId'];
  }

  function general($to, $template, $subject = 'Untitled', $data = [])
  {
    $message = $this->CI->load->view('email/'.$template, $data, TRUE);

    $this->CI->load->library('composer/lib_html_to_markdown');
    $alt_message = $this->CI->lib_html_to_markdown->convert($message);

    $message = $this->CI->load->view('email/base', ['subject' => $subject, 'message' => $message], TRUE);

    return $this->direct($to, $subject, $message, $alt_message);
  }
}