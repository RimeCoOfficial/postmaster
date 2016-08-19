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

    function direct($to_email, $subject = '', $body_html = '')
    {
        $body_text = html_to_text($body_html);

        $this->CI->load->library('composer/lib_aws');
        $ses_client = $this->CI->lib_aws->get_ses();

        try {
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
                'Source' => '"'.app_name().'" <'.getenv('email_postmaster').'>',
            ]);
        } catch (AwsException $e) {
            // handle the error.
            $error_msg = 'getAwsRequestId: '.$e->getAwsRequestId().', getAwsErrorType:'.$e->getAwsErrorType().', getAwsErrorCode:'.$e->getAwsErrorCode()."\n\n";
            $error_msg .= $e->getMessage()."\n";
            $error_msg .= $e->getTraceAsString();
        }

        if (empty($result))
        {
            $this->error = ['message' => $error_msg];
            return NULL;
        }
        else if (!empty($result['MessageId']))
        {
            $result = $result->toArray();
            return $result;
        }
        else
        {
            $this->error = ['message' => 'Result missing MessageId', 'result' => $result];
            return NULL;
        }
    }

    function general($to_email, $subject = 'Untitled', $template, $data = [])
    {
        $message = $this->CI->load->view('email/'.$template, $data, TRUE);

        if (ENVIRONMENT === 'production') return $this->direct($to_email, $subject, $message);
        else                              return TRUE;
    }

    // @todo: general => error
    // function error($to_email, $subject = 'Untitled', $template, $data = []) {}
}