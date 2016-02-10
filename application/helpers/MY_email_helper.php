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

/*
// http://www.enewsletterpro.com/articles/multi_part_mime_messages.asp

X-sender: <sender@sendersdomain.com>
X-receiver: <somerecipient@recipientdomain.com>
From: "Senders Name" <sender@sendersdomain.com>
To: "Recipient Name" <somerecipient@recipientdomain.com>
Message-ID: <5bec11c119194c14999e592feb46e3cf@sendersdomain.com>
Date: Sat, 24 Sep 2005 15:06:49 -0400
Subject: Sample Multi-Part
MIME-Version: 1.0
Content-Type: multipart/alternative; 
boundary="----=_NextPart_DC7E1BB5_1105_4DB3_BAE3_2A6208EB099D"

------=_NextPart_DC7E1BB5_1105_4DB3_BAE3_2A6208EB099D
Content-type: text/plain; charset=iso-8859-1
Content-Transfer-Encoding: quoted-printable

Sample Text Content
------=_NextPart_DC7E1BB5_1105_4DB3_BAE3_2A6208EB099D
Content-type: text/html; charset=iso-8859-1
Content-Transfer-Encoding: quoted-printable

<html>
<head>
</head>
<body>
<div style=3D"FONT-SIZE: 10pt; FONT-FAMILY: Arial">Sample HTML =
Content</div>
</body>
</html>

------=_NextPart_DC7E1BB5_1105_4DB3_BAE3_2A6208EB099D--
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
  $msg .= 'From: '.$from."\n";
  $msg .= 'To: '.$to."\n";

  if (!empty($reply_to)) $msg .= 'Reply-To: '.$reply_to."\n";

  // in case you have funny characters in the subject
  $subject = mb_encode_mimeheader($subject, 'UTF-8');
  $msg .= 'Subject: '.$subject."\n";
  
  if (!empty($message['list_unsubscribe'])) $msg .= 'List-Unsubscribe: '.$message['list_unsubscribe']."\n";

  $msg .= 'X-Mailer: '.$client_name.' via '.app_name()."\n";
  
  $msg .= 'MIME-Version: 1.0'."\n";
  $msg .= 'Content-Type: multipart/mixed;'."\n";
  
  $boundary_hash = sha1(time()); //random unique strin
  $msg .= "\t".'boundary="'.$boundary_hash.'"'."\n";
  $msg .= "\n";

  // now the actual body
  $msg .= '--'.$boundary_hash."\n";

  // first, the plain text
  $msg .= 'Content-Type: text/plain; charset=utf-8'."\n";
  $msg .= 'Content-Transfer-Encoding: 7bit'."\n";
  $msg .= "\n";
  $msg .= $body_text; // strip_tags($body); //remove any HTML tags
  $msg .= "\n";

  // now, the html text
  $msg .= '--'.$boundary_hash."\n";
  $msg .= 'Content-Type: text/html; charset=utf-8'."\n";
  $msg .= 'Content-Transfer-Encoding: 7bit'."\n";
  $msg .= "\n";
  $msg .= $body_html;
  $msg .= "\n";
  $msg .= '--'.$boundary_hash.'--'."\n";

  return $msg;
}