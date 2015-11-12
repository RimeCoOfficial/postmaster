<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExceptionHook 
{
  public function SetExceptionHandler()
  {
    // if ( ! str_ireplace(array('off', 'none', 'no', 'false', 'null'), '', ini_get('display_errors')))
    if (ENVIRONMENT === 'production')
    {
      set_exception_handler(array($this, 'HandleExceptions'));
    }
  }
   
  public function HandleExceptions($exception)
  {
    $message = [
      'Type' => get_class($exception),
      'Message' => $exception->getMessage(),
      'File' => $exception->getFile(),
      'Line' => $exception->getLine(),
      'Backtrace' => "\n\n".$exception->getTraceAsString()."\n",
      // 'Backtrace' => $exception->getTrace(),
    ];

    // $_error->log_exception('error', 'Exception: '.$exception->getMessage(), $exception->getFile(), $exception->getLine());
    $severity = 'error';
    $message = 'Exception: '.'<pre>'.print_r($message, TRUE).'</pre>';
    $filepath = $exception->getFile();
    $line = $exception->getLine();

    log_message('error', 'Severity: '.$severity.' --> '.$message.' '.$filepath.' '.$line);

    if (!is_null($CI =& get_instance()))
    {
      $data['severity'] = $severity;
      $data['message']  = $message;
      $data['filepath'] = $filepath;
      $data['line']     = $line;

      $CI->load->helper('email');
      report_error('An uncaught Exception was encountered', 'error/error_exception', $data);
    }

    exit(1); // EXIT_ERROR
  }
}