<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_status
{
  private $error = array();
  
  function __construct($options = array())
  {
    $this->CI =& get_instance();

    $this->CI->load->model('model_status');
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

  function get($email_id)
  {
    return $this->CI->model_status->get($email_id);
  }

  function process_notification_queue($queue_type = 'bounces') // type = bounces, complaints, deliveries
  {
    $this->CI->load->library('composer/lib_aws');
    $sqs_client = $this->CI->lib_aws->get_sqs();

    // $result = $sqs_client->ListQueues();
    // echo '<pre>' . print_r($result, TRUE) . '</pre>';

    // https://sqs.us-west-2.amazonaws.com/927493227978/bounces
    // https://sqs.us-west-2.amazonaws.com/927493227978/complaints
    // https://sqs.us-west-2.amazonaws.com/927493227978/deliveries
    $queue_url = 'https://sqs.'.$this->CI->config->item('aws_region', 'api_key').'.amazonaws.com/'.$this->CI->config->item('aws_account_id', 'api_key').'/' .$this->CI->config->item('aws_prefix', 'api_key'). '-ses-'.$queue_type.'-queue';

    $result = $sqs_client->receiveMessage(array(
      'QueueUrl' => $queue_url,
      'MaxNumberOfMessages' => 10,
    ));

    // echo '<pre>' . print_r($result, TRUE) . '</pre>';

    if (empty($result['Messages']))
    {
      exit('@kill-task: Queue empty!');
      
      $this->error = array('message' => 'Queue empty!');
      return NULL;
    }

    foreach ($result['Messages'] as $message)
    {
      $message_body = json_decode($message['Body'], TRUE);

      if (!empty($message_body['Message']))
      {
        $ses_message = json_decode($message_body['Message'], TRUE);
        // var_dump($ses_message);

        if (!empty($ses_message['mail']['destination'][0]))
        {
          // $email_id = $ses_message['mail']['destination'][0];
          // $email_id = strtolower($email_id);
          
          $this->CI->load->helper('email');
          
          if (!is_null($email_id = valid_email($ses_message['mail']['destination'][0])))
          {
            $this->CI->model_status->store($email_id);
            $state = array();

            if (!empty($ses_message['bounce']))
            {
              $state['status'] = 'bounce';
              $state['status_type'] = strtolower($ses_message['bounce']['bounceSubType'].'/'.$ses_message['bounce']['bounceType']);
              $state['status_timestamp'] = date('Y-m-d H:i:s', strtotime($ses_message['bounce']['timestamp']));
            }

            if (!empty($ses_message['complaint']))
            {
              $state['status'] = 'complaint';
              $state['status_type'] = $ses_message['complaint']['complaintFeedbackType'];
              $state['status_timestamp'] = date('Y-m-d H:i:s', strtotime($ses_message['complaint']['timestamp']));
            }

            if (!empty($ses_message['delivery']))
            {
              $state['status'] = 'delivery';
              $state['status_type'] = $ses_message['delivery']['smtpResponse'];
              $state['status_timestamp'] = date('Y-m-d H:i:s', strtotime($ses_message['delivery']['timestamp']));
            }

            $state['status_json'] = $message_body['Message'];

            $this->CI->model_status->update_status($email_id, $state);

            echo $email_id.': '.$state['status'].' '.$state['status_type'].PHP_EOL;
          }
        }
      }

      if (!empty($message['ReceiptHandle']))
      {
        echo 'Delete message: '.$message['ReceiptHandle'];
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

  function stats()
  {
    $stats = array(
      'aws' => $this->CI->model_status->stats(),
      'unsubscribe' => $this->CI->model_status->stats_unsubscribe(),
    );
    return $stats;
  }
}
