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
      'MaxNumberOfMessages' => 9, // MaxNumberOfMessages: Must be between 1 and 10, if provided.
    ));

    if (empty($result['Messages']))
    {
      exit('@kill-task: No task found');
    }

    foreach ($result['Messages'] as $sqs_message)
    {
      if (!empty($sqs_message['Body']))
      {
        $sns_message = json_decode($sqs_message['Body'], TRUE);
        if (!empty($sns_message['Message']))
        {
          $feedback = NULL;

          $ses_message = json_decode($sns_message['Message'], TRUE);
          if (!empty($ses_message['bounce']))
          {
            $feedback = [
              'type' => 'bounce',
              'sub_type' => $ses_message['bounce']['bounceSubType'].', '.$ses_message['bounce']['bounceType'],
              'to_email' => $ses_message['bounce']['bouncedRecipients'][0]['emailAddress'],
            ];
          }
          elseif (!empty($ses_message['complaint']))
          {
            $feedback = [
              'type' => 'complaint',
              'sub_type' => $ses_message['complaint']['complaintFeedbackType'],
              'to_email' => $ses_message['complaint']['complainedRecipients'][0]['emailAddress'],
            ];
          }
          elseif (!empty($ses_message['delivery']))
          {
            $feedback = [
              'type' => 'delivery',
              'sub_type' => $ses_message['delivery']['smtpResponse'],
              'to_email' => $ses_message['delivery']['recipients'][0],
            ];
          }
          
          if (!empty($feedback))
          {
            $feedback['sub_type'] = !empty($feedback['sub_type']) ? character_limiter($feedback['sub_type'], 64) : NULL;
            $feedback['recieved'] = date('Y-m-d H:i:s', strtotime($ses_message['mail']['timestamp']));

            $this->CI->model_feedback->store($feedback['to_email']);
            $this->CI->model_feedback->update($feedback);

            echo "\t".'Email address: '.$feedback['to_email'].', '.$feedback['type'].' ['.$feedback['sub_type'].']'.PHP_EOL;
          }
          else print_r($ses_message);
        }
      }

      if (!empty($sqs_message['ReceiptHandle']))
      {
        echo "\t".'Delete message SQS: '.$sqs_message['ReceiptHandle'].PHP_EOL;
        $receipt_handle = $sqs_message['ReceiptHandle'];

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

  function get($to_email)
  {
    return $this->CI->model_feedback->get($to_email);
  }

  function get_batch($to_email_list)
  {
    $feedback_list = $this->CI->model_feedback->get_batch($to_email_list);

    $feedback_type_list = [];
    foreach ($feedback_list as $feedback) $feedback_type_list[ $feedback['to_email'] ] = $feedback['type'];
    
    return $feedback_type_list;
  }

  function stats()
  {
    return $this->CI->model_feedback->stats();
  }
}
