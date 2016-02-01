<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_feedback
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();
    $this->CI->load->model('model_feedback');
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

  function process_notification($queue_type)
  {
    $this->CI->load->library('composer/lib_aws');
    $sqs_client = $this->CI->lib_aws->get_sqs();

    // $result = $sqs_client->ListQueues(); print_r($result); die();

    $config = $this->CI->config->item('aws', 'api_key');

    // https://sqs.us-west-2.amazonaws.com/012345678901/ses-bounces
    // https://sqs.us-west-2.amazonaws.com/012345678901/ses-complaints
    // https://sqs.us-west-2.amazonaws.com/012345678901/ses-deliveries
    $queue_url = 'https://sqs.'.$config['region'].'.amazonaws.com/'.$config['account_id'].'/ses-'.$queue_type;

    $result = $sqs_client->receiveMessage(array(
      'QueueUrl' => $queue_url,
      'MaxNumberOfMessages' => 10,
    ));

    if (empty($result['Messages']))
    {
      exit('@kill-task: No task found');
    }

    foreach ($result['Messages'] as $message)
    {
      if (!empty($message['Body']))
      {
        $message_body = json_decode($message['Body'], TRUE);

        if (!empty($message_body['Message']))
        {
          $ses_message = json_decode($message_body['Message'], TRUE);

          $state = array();

          if (!empty($ses_message['bounce']))
          {
            $state['state'] = 'bounce';
            $state['type'] = strtolower($ses_message['bounce']['bounceSubType'].'/'.$ses_message['bounce']['bounceType']);
            $state['timestamp'] = date('Y-m-d H:i:s', strtotime($ses_message['bounce']['timestamp']));

            $email_id = $ses_message['bounce']['bouncedRecipients'][0]['emailAddress'];
          }

          if (!empty($ses_message['complaint']))
          {
            $state['state'] = 'complaint';
            $state['type'] = $ses_message['complaint']['complaintFeedbackType'];
            $state['timestamp'] = date('Y-m-d H:i:s', strtotime($ses_message['complaint']['timestamp']));

            $email_id = $ses_message['complaint']['complainedRecipients'][0]['emailAddress'];
          }

          if (!empty($ses_message['delivery']))
          {
            $state['state'] = 'delivery';
            $state['type'] = $ses_message['delivery']['smtpResponse'];
            $state['timestamp'] = date('Y-m-d H:i:s', strtotime($ses_message['delivery']['timestamp']));

            $email_id = $ses_message['delivery']['recipients'][0];
          }

          $state['message_json'] = $message_body['Message'];
          
          $this->CI->load->helper('email');
          if (is_null($email_id = valid_email($email_id)))
          {
            throw new Exception("Not a valid email: ".$email_id, 1);
          }

          $this->CI->model_feedback->store($email_id);
          $this->CI->model_feedback->update($email_id, $state);

          echo "\t- ".'Email: '.$email_id.', state: '.$state['state'].', type: '.$state['type'].PHP_EOL;
        }
      }

      if (!empty($message['ReceiptHandle']))
      {
        echo "\t- ".'Delete message: '.$message['ReceiptHandle'].PHP_EOL;
        $receipt_handle = $message['ReceiptHandle'];

        $sqs_client->deleteMessage(array(
          // QueueUrl is required
          'QueueUrl' => $queue_url,
          // ReceiptHandle is required
          'ReceiptHandle' => $receipt_handle,
        ));
      }
    }

    return TRUE;
  }

  function get($email_id)
  {
    return $this->CI->model_feedback->get($email_id);
  }

  function stats()
  {
    return $this->CI->model_feedback->stats();
  }
}
