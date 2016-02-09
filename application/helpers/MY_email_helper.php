<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function valid_email($str)
{
  $CI =& get_instance();

  // 1. lowercse
  $str = strtolower($str);

  // 2. idn to ascii
  $CI->load->library('composer/lib_idna_convert');
  $str = $CI->lib_idna_convert->encode($str);

  // 3. trim
  $str = trim($str);

  // 4. required
  if (empty($str)) return NULL;

  // 5. max length
  $CI->config->load('form_element', TRUE);

  $email_element = $CI->config->item('email', 'form_element');
  $email_max_length = $email_element['max_length'];
  if (strlen($str) > $email_max_length) return NULL;

  return filter_var($str, FILTER_VALIDATE_EMAIL) ? $str : NULL;
}

function report_error($subject, $template, $data)
{
  if (!is_null($CI =& get_instance()) AND ENVIRONMENT === 'production')
  {
    $data['debug_backtrace'] = NULL;
    $data['backtrace'] = array();
    if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE)
    {
      // $data['debug_backtrace'] = debug_backtrace();
      foreach (debug_backtrace() as $error)
      {
        if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0)
        {
          $b['file'] = $error['file'];
          $b['line'] = $error['line'];
          $b['function'] = $error['function'];

          $b['args'] = $error['args'];

          $data['backtrace'][] = $b;
        }
      }
    }

    if (is_cli()) $subject = 'CLI: '.$subject;

    $data['ip']       = is_cli() ? NULL : $CI->input->ip_address();

    $data['request']  = $_REQUEST;
    $data['server']   = is_cli() ? NULL : $CI->input->server(NULL);
    
    $CI->load->library('lib_send_email');
    $CI->lib_send_email->general(getenv('email_debug'), $subject, $template, $data);
  }
}

// http://www.codeproject.com/Articles/786596/How-to-Use-Amazon-SES-to-Send-Email-from-PHP
// $params = array(
//   "to" => "email1@gmail.com",
//   "to" => "email1@gmail.com",
//   "subject" => "Some subject",
//   "message" => "<strong>Some email body</strong>",
//   "from" => "sender@verifiedbyaws",
//   //OPTIONAL
//   "reply_to" => "reply_to@gmail.com",
//   //OPTIONAL
//   "files" => array(
//     1 => array(
//        "name" => "filename1",
//       "filepath" => "/path/to/file1.txt",
//       "mime" => "application/octet-stream"
//     ),
//     2 => array(
//        "name" => "filename2",
//       "filepath" => "/path/to/file2.txt",
//       "mime" => "application/octet-stream"
//     ),
//   )
// );
function ses_raw_email($message)
{
  $client_name = getenv('app_name');

  // $to = !empty($message['to_name']) ? $message['to_name'].' <'.$message['to_email'].'>' : $message['to_email'];
  $to = 'debug-postmaster@rime.co';
  $subject = $message['subject'];
  $body_html = $message['body_html'];
  $body_text = $message['body_text'];
  $from = $message['from_name'].' <'.$message['from_email'].'>';
  $reply_to = NULL;

  if (!empty($message['reply_to_email']))
  {
    $reply_to = (!empty($message['reply_to_name']) ? $message['reply_to_name'] : $client_name).' <'.$message['reply_to_email'].'>';
  }

  $msg = '';
  $msg = "To: $to\n";
  $msg .= "From: $from\n";

  if (!empty($reply_to)) $msg .= "Reply-To: $reply_to\n";

  // in case you have funny characters in the subject
  $subject = mb_encode_mimeheader($subject, 'UTF-8');
  $msg .= "Subject: $subject\n";
  
  if (!empty($message['list_unsubscribe'])) $msg .= 'List-Unsubscribe: '.$message['list_unsubscribe']."\n";

  $msg .= 'X-Mailer: '.$client_name.' via '.app_name()."\n";
  
  $msg .= "MIME-Version: 1.0\n";
  $msg .= "Content-Type: multipart/mixed;\n";
  $boundary = uniqid("_Part_".time(), true); //random unique string
  $boundary2 = uniqid("_Part2_".time(), true); //random unique string
  $msg .= " boundary=\"$boundary\"\n";
  $msg .= "\n";

  // now the actual body
  $msg .= "--$boundary\n";

  //since we are sending text and html emails with multiple attachments
  //we must use a combination of mixed and alternative boundaries
  //hence the use of boundary and boundary2
  $msg .= "Content-Type: multipart/alternative;\n";
  $msg .= " boundary=\"$boundary2\"\n";
  $msg .= "\n";
  $msg .= "--$boundary2\n";

  // first, the plain text
  $msg .= "Content-Type: text/plain; charset=utf-8\n";
  $msg .= "Content-Transfer-Encoding: 7bit\n";
  $msg .= "\n";
  $msg .= $body_text; // strip_tags($body); //remove any HTML tags
  $msg .= "\n";

  // now, the html text
  $msg .= "--$boundary2\n";
  $msg .= "Content-Type: text/html; charset=utf-8\n";
  $msg .= "Content-Transfer-Encoding: 7bit\n";
  $msg .= "\n";
  $msg .= $body_html;
  $msg .= "\n";
  $msg .= "--$boundary2--\n";

  return $msg;
}