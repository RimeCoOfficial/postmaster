<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Promise;

class Lib_message_archive
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_message_archive');
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

  function get($request_id, $web_version_key)
  {
    return $this->CI->model_message_archive->get($request_id, $web_version_key);
  }

  function get_list($owner)
  {
    $count = 100;
    return $this->CI->model_message_archive->get_list($owner, $count);
  }

  function get_unsent($count)
  {
    return $this->CI->model_message_archive->get_unsent($count);
  }

  function send($messages)
  {
    // 1. send emails async
    $this->CI->load->library('composer/lib_aws');
    $ses_client = $this->CI->lib_aws->get_ses();
    $promises = [];

    foreach ($messages as $message)
    {
      echo '('.$message['request_id'].') Sending message: '.$message['subject'].', to: '.$message['to_email'].PHP_EOL;

      // list_unsubscribe header
      // email_key

      $promises[ $message['request_id'] ] = $ses_client->sendEmailAsync([
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
    foreach ($results as $request_id => $result)
    {
      if (!empty($result['@metadata']['statusCode']) AND $result['@metadata']['statusCode'] == 200
        AND !empty($result['MessageId'])
      )
      {
        $amzn_message_id = $result['MessageId'];
        $message_sent_list[] = ['request_id' => $request_id, 'sent' => date('Y-m-d H:i:s'), 'amzn_message_id' => $amzn_message_id];
      }
    }

    // mark sent
    $this->CI->model_message_archive->mark_sent($message_sent_list);

    return TRUE;
  }
}