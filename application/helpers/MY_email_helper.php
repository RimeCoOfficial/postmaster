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

// trigger_error('Blowing In The Wind (Live On TV, March 1963)', E_USER_ERROR);
// throw new Exception("No woman no cry", 1);
// show_error('Underneath the bridge.', 503);
function report_error($template, $message_data)
{
  if (ENVIRONMENT !== 'production') return;
  
  $CI =& get_instance();

  switch ($template) {
    case 'error_404':       $subject = '404 Page Not Found'; break;
    case 'error_db':        $subject = 'Database Error'; break;
    case 'error_exception': $subject = 'An uncaught Exception was encountered'; break;
    case 'error_general':   $subject = 'An Error Was Encountered'; break;
    case 'error_php':       $subject = 'A PHP Error was encountered'; break;
    default:                $subject = 'ERROR';
  }

  if (is_cli()) $subject = 'CLI: '.$subject;
  else          $subject = $CI->input->ip_address().': '.$subject;

  // $request  = $_REQUEST;
  // $server   = $is_cli ? NULL : $this->CI->input->server(NULL);

  $CI->load->library('email');

  $CI->email->from(getenv('email_postmaster'), 'Postmaster');
  $CI->email->to(getenv('email_admin'));
  // $CI->email->cc('another@another-example.com'); 
  // $CI->email->bcc('them@their-example.com'); 

  $CI->email->subject($subject);

  $message = $CI->load->view('errors/html/'.$template, $message_data, TRUE);
  $alt_message = $CI->load->view('errors/cli/'.$template, $message_data, TRUE);

  $CI->email->message($message);
  $CI->email->set_alt_message($alt_message);

  // var_dump($subject, $alt_message); die();

  if ( ! $CI->email->send())
  {
    // Generate error
    // echo $CI->email->print_debugger();
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

  $to = !empty($message['to_name']) ? '"'.str_replace('"', '\"', $message['to_name']).'" <'.$message['to_email'].'>' : $message['to_email'];
  
  // @debug: send to debug
  // $to = 'www@suvozit.com';

  $subject = $message['subject'];
  $body_html = $message['body_html'];
  $body_text = $message['body_text'];
  $from = !empty($message['from_name']) ? '"'.str_replace('"', '\"', $message['from_name']).'" <'.$message['from_email'].'>' : $message['from_email'];
  $reply_to = NULL;

  if (!empty($message['reply_to_email']))
  {
    $reply_to = (!empty($message['reply_to_name']) ? $message['reply_to_name'] : $client_name);
    $reply_to = '"'.str_replace('"', '\"', $reply_to).'" <'.$message['reply_to_email'].'>';
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
  $msg .= 'X-About: http://rimeofficial.github.io/postmaster'."\n";
  
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