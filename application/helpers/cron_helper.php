<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('LOCK_DIR', '/tmp/');
define('LOCK_SUFFIX', '.lock');

function job_name()
{
  $CI =& get_instance();
  $segments = $CI->uri->segment_array();

  $job_name = implode('/', $segments);

  return $job_name;
}

function _check_lock_file()
{
  $lock_file = LOCK_DIR.'ci_cron'.LOCK_SUFFIX;

  if (!file_exists($lock_file))
  {
    echo 'Cron Lock: Create lock_file: '.$lock_file.PHP_EOL;
    touch($lock_file);
  }
  // else unlink($lock_file); die('Reset cron lock!'.PHP_EOL); // @debug

  return $lock_file;
}

function _read_lock_file($force_reset = FALSE)
{
  $lock_file = _check_lock_file();
  $tasks_json = file_get_contents($lock_file);

  return json_decode($tasks_json, TRUE);
}

function _write_lock_file($tasks)
{
  $lock_file = _check_lock_file();
  $tasks_json = json_encode($tasks);

  return file_put_contents($lock_file, $tasks_json);
}

function is_running()
{
  $job_name = job_name();
  $tasks = _read_lock_file();

  echo 'Cron Lock: Check status'.PHP_EOL;
  if (!empty($tasks[ $job_name ]))
  {
    $pid = $tasks[ $job_name ];

    echo "\t".'- Task registered pid '.$pid.PHP_EOL;

    // $running_pids = explode(PHP_EOL, `ps -e | awk '{print $1}'`);

    // @ = silent fail in front of shell_exec to prevent warnings
    $result = @shell_exec("ps -e | awk '{print $1}'");
    if (is_null($result)) exit('shell_exec failed');

    $running_pids = explode(PHP_EOL, $result);

    if (in_array($pid, $running_pids))
    {
      echo "\t".'- Task already running'.PHP_EOL;
      return TRUE;
    }
  }

  echo "\t".'- Task not running'.PHP_EOL;
  return FALSE;
}

function lock()
{
  $job_name = job_name();
  $tasks = _read_lock_file();

  $pid = getmypid();
  $tasks[ $job_name ] = $pid;

  _write_lock_file($tasks);

  echo 'Cron Lock: Locked '.$pid.' - '.$job_name.PHP_EOL;
  return $pid;
}

function unlock($all = 0)
{
  $job_name = job_name();
  $tasks = _read_lock_file();

  if (empty($tasks[ $job_name ])) return;

  $pid = $tasks[ $job_name ];
  unset($tasks[ $job_name ]);

  _write_lock_file($tasks);

  echo 'Cron Lock: Unlocked '.$pid.' - '.$job_name.PHP_EOL;

  gc_collect_cycles();
}

function reset_lock()
{
  $lock_file = _check_lock_file();
  unlink($lock_file);
}
