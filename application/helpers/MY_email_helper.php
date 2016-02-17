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
  $email_debug = getenv('email_debug');

  if (!is_null($CI =& get_instance()) AND ENVIRONMENT === 'production' AND !empty($email_debug))
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
    $data['whoami']   = exec('whoami');

    $data['request']  = $_REQUEST;
    $data['server']   = is_cli() ? NULL : $CI->input->server(NULL);
    
    $CI->load->library('lib_send_email');
    $CI->lib_send_email->general($email_debug, $subject, $template, $data);
  }
}

/*
To: "Shubhajit Saha" <www@suvozit.com>
From: "Rime" <postmaster@rime.co>
Subject: Test
MIME-Version: 1.0
Content-type: Multipart/Mixed; boundary="173845068356bad52248f408.42032165"

--173845068356bad52248f408.42032165
Content-type: Multipart/Alternative; boundary="alt-173845068356bad52248f408.42032165"

--alt-173845068356bad52248f408.42032165
Content-Type: text/plain; charset="UTF-8"

This is the message body.

--alt-173845068356bad52248f408.42032165
Content-Type: text/html; charset="UTF-8"

This is the <b>message</b> body.

--alt-173845068356bad52248f408.42032165--

--173845068356bad52248f408.42032165--
*/
function ses_raw_email($message)
{
  $client_name = getenv('app_name');

  $to = !empty($message['to_name']) ? '"'.$message['to_name'].'" <'.$message['to_email'].'>' : $message['to_email'];
  
  // @debug: send to debug
  // $to = 'www@suvozit.com';

  $subject = $message['subject'];
  $body_html = $message['body_html'];
  $body_text = $message['body_text'];
  $from = !empty($message['from_name']) ? '"'.$message['from_name'].'" <'.$message['from_email'].'>' : $message['from_email'];
  $reply_to = NULL;

  if (!empty($message['reply_to_email']))
  {
    $reply_to = (!empty($message['reply_to_name']) ? $message['reply_to_name'] : $client_name).' <'.$message['reply_to_email'].'>';
  }

  $msg = '';
  $msg .= 'To: '.$to."\n";
  $msg .= 'From: '.$from."\n";

  if (!empty($reply_to)) $msg .= 'Reply-To: '.$reply_to."\n";

  // in case you have funny characters in the subject
  $subject = mb_encode_mimeheader($subject, 'UTF-8');
  $msg .= 'Subject: '.$subject."\n";
  
  if (!empty($message['list_unsubscribe'])) $msg .= 'List-Unsubscribe: '.$message['list_unsubscribe']."\n";

  $msg .= 'X-Mailer: '.$client_name.' via '.app_name()."\n";
  
  // random unique string
  $boundary_hash = md5($message['request_id'].'.'.time());

  $msg .= 'MIME-Version: 1.0'."\n";
  $msg .= 'Content-Type: Multipart/Mixed; boundary="'.$boundary_hash.'"'."\n";

  // now the actual body
  $msg .= "\n".'--'.$boundary_hash."\n";
  $msg .= 'Content-type: Multipart/Alternative; boundary="alt-'.$boundary_hash.'"'."\n";
  $msg .= "\n";

  // first, the plain text
  $msg .= 'Content-Type: text/plain; charset="UTF-8"'."\n";
  $msg .= "\n";
  $msg .= $body_text; // strip_tags($body); // remove any HTML tags
  $msg .= "\n";

  // now, the html text
  $msg .= "\n".'--alt-'.$boundary_hash."\n";
  $msg .= 'Content-Type: text/html; charset="UTF-8"'."\n";
  $msg .= "\n";
  $msg .= $body_html;
  $msg .= "\n";
  $msg .= "\n".'--'.$boundary_hash.'--'."\n";

  return $msg;
}