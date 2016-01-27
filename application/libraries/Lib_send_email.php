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

  function direct($to_email, $subject = '', $body_html = '', $body_text = '')
  {
    $this->CI->load->library('composer/lib_aws');
    $ses_client = $this->CI->lib_aws->get_ses();

    $result = $ses_client->sendEmail([
      'Destination' => [
        'ToAddresses' => [$to_email],
      ],
      'Message' => [
        'Body' => [
          'Html' => ['Data' => $body_html],
          'Text' => ['Data' => $body_text],
        ],
        'Subject' => ['Data' => $subject],
      ],
      'Source' => getenv('email_source'),
    ]);

    return $result['MessageId'];
  }

  function general($to_email, $subject = 'Untitled', $template, $data = [])
  {
    $message = $this->CI->load->view('email/'.$template, $data, TRUE);
    $alt_message = html_to_text($message);

    return $this->direct($to_email, $subject, $message, $alt_message);
  }
}