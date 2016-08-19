<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_auth
{
    private $error = array();
    
    function __construct($options = array())
    {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
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

    public function is_logged_in()
    {
        return !empty($this->CI->session->userdata('is_logged_in'));
    }

    function sign_in($email_webmaster)
    {
        $email_webmaster_all = getenv('email_webmaster');

        if (strpos($email_webmaster_all, $email_webmaster) === FALSE)
        {
            $this->error = ['status' => 401, 'message' => 'invalid admin email'];
            return NULL;
        }

        if (!is_null($this->CI->session->userdata('login_email_key')))
        {
            $this->error = ['status' => 401, 'message' => 'Slow down boy, try after 15 mins or create a new session'];
            return NULL;
        }

        $login_email_key = random_string('md5');
        $this->CI->session->set_tempdata('login_email_key', $login_email_key, 900); // Expire in 15 minutes

        return $login_email_key;
    }

    function verify($login_email_key)
    {
        $session_login_email_key = $this->CI->session->userdata('login_email_key');

        if ($login_email_key == $session_login_email_key)
        {
            // destroy login key
            $this->CI->session->unset_userdata('login_email_key');

            $this->CI->session->set_userdata('is_logged_in', TRUE);
            return TRUE;
        }
        else
        {
            $this->error = ['status' => 401, 'message' => 'login didnt match, so try again babe!'];
            return NULL;
        }
    }

    function sign_out()
    {
        $this->CI->session->unset_userdata('is_logged_in');
        $this->CI->session->sess_destroy();
    }
}