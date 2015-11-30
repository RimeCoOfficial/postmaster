<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Promise;

class Lib_message_send
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_message_send');
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

  function get_to_send($count)
  {
    return $this->CI->model_message_send->get_to_send($count);
  }

  function send($messages)
  {
    // 1. send emails async

    $this->CI->load->library('composer/lib_aws');
    $ses_client = $this->CI->lib_aws->get_ses();
    $promises = [];

    foreach ($messages as $message)
    {
      echo '('.$message['history_id'].') Sending message: '.$message['subject'].', to: '.$message['to_email'].PHP_EOL;

      $promises[ $message['history_id'] ] = $ses_client->sendEmailAsync([
          'Destination' => [
          'ToAddresses' => [$message['to_email']],
        ],
        'Message' => [
          'Body' => [
            'Html' => ['Data' => $message['body_html']],
            'Text' => ['Data' => $message['body_text']],
          ],
          'Subject' => ['Data' => $message['subject']],
        ],
        'Source' => getenv('email_source'),
      ]);
    }

    // Wait on both promises to complete and return the results.
    $results = Promise\unwrap($promises);

    // 2. save messege_id
    $message_sent_list = [];
    foreach ($results as $history_id => $result)
    {
      if (!empty($result['@metadata']['statusCode']) AND $result['@metadata']['statusCode'] == 200
        AND !empty($result['MessageId'])
      )
      {
        $amzn_message_id = $result['MessageId'];
        $message_sent_list[] = ['history_id' => $history_id, 'email_sent' => date('Y-m-d H:i:s'), 'amzn_message_id' => $amzn_message_id];
      }
    }

    // mark sent
    $this->CI->model_message_send->mark_sent($message_sent_list);

    return TRUE;
  }
}