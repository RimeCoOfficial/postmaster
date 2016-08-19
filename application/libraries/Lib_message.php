<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Sunra\PhpSimple\HtmlDomParser;

class Lib_message
{
    private $error = array();
    
    function __construct($options = array())
    {
        $this->CI =& get_instance();
        $this->CI->load->model('model_message');
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

    function get($message_id)
    {
        return $this->CI->model_message->get($message_id);
    }

    function get_list()
    {
        return $this->CI->model_message->get_list();
    }

    function create($subject, $list_id)
    {
        return $this->CI->model_message->create($subject, $list_id);
    }

    function update($message, $subject, $body_html_input, $reply_to_name, $reply_to_email)
    {
        if ($message['archived'] != '1000-01-01 00:00:00')
        {
            $this->error = ['message' => 'Didn&#8217;t I told you! The message is archived and can not be modified'];
            return NULL;
        }

        if (is_null($result = $this->_process_html($message, $body_html_input)))
        {
            return NULL;
        }

        if (empty($reply_to_name)) $reply_to_name = NULL;
        if (empty($reply_to_email)) $reply_to_email = NULL;

        $list_unsubscribe = strpos($result['body_html'], '{_unsubscribe_link}') !== false;

        $this->CI->model_message->update(
            $message['message_id'], $subject, $body_html_input, $result['body_html'], $result['body_text'], $reply_to_name, $reply_to_email, $list_unsubscribe
        );

        if ($message['type'] == 'transactional' AND is_null($message['published_tds']))
        {
            $this->CI->model_message->update_publish($message['message_id'], 0);
        }
        
        return $message;
    }

    function publish($message, $php_datetime_str)
    {
        $date_from_str = '1000-01-01 00:00:00';
        $date_from = strtotime($date_from_str);

        if ($message['type'] == 'transactional')
        {
            $this->error = ['message' => 'transactional messages are automatically set to zero when updated or unarchived'];
            return NULL;
        }

        switch ($message['type'])
        {
            case 'autoresponder':
                $date_to = strtotime($php_datetime_str, $date_from);
                break;
            
            case 'campaign':
                $date_to = strtotime($php_datetime_str, strtotime('now'));
                break;
        }

        if (!$date_to)
        {
            $this->error = ['message' => 'strtotime returned bool(false). Valid formats are explained in [Date and Time Formats](http://php.net/manual/en/datetime.formats.php).'];
            return NULL;
        }

        // Difference in seconds
        // Autoresponder: +1 day = 86400
        // Campaign:      +1 day = 32064136828
        // Transactional: now = 0
        $diff_in_seconds = $date_to - $date_from;

        $this->CI->model_message->update_publish($message['message_id'], $diff_in_seconds);
        return TRUE;
    }

    function archive($message_id)
    {
        $message = $this->get($message_id);
        if (empty($message))
        {
            $this->error = ['message' => 'invalid message id'];
            return NULL;
        }

        if ($message['type'] == 'campaign')
        {
            $this->error = ['message' => 'campaign messages are archived automatically'];
            return NULL;
        }

        $this->CI->model_message->archive($message_id);
        return TRUE;
    }

    function unarchive($message_id)
    {
        $message = $this->get($message_id);
        if (empty($message))
        {
            $this->error = ['message' => 'invalid message id'];
            return NULL;
        }

        if ($message['type'] == 'campaign')
        {
            $this->error = ['message' => 'campaign messages are archived automatically'];
            return NULL;
        }

        $this->CI->model_message->unarchive($message_id, $message['type']);
        return $message['type'];
    }

    function _process_html($message, $body_html_input)
    {
        $body_html = $body_html_input;

        // 1. html to text
        $body_text = html_to_text($body_html);

        $ga_vars = [
            'tracking_id' => getenv('ga'),
            'campaign_source' => $message['list'].'-'.$message['message_id'],
            'campaign_name' => $message['message_id'].' '.$message['subject'],
            'campaign_medium' => 'email',
        ];

        // 2. GA stats (event: click)
        // Campaign Source    utm_source=[list]
        // Campaign Name      utm_campaign=[message_id]
        // Campaign Medium    utm_medium=email
        // Campaign Content   utm_content=hyperlink
        $ga_hyperlink = [
            'utm_source' => $ga_vars['campaign_source'],
            'utm_campaign' => $ga_vars['campaign_name'],
            'utm_medium' => $ga_vars['campaign_medium'],
            'utm_content'  => 'hyperlink',
        ];

        // 3. GA stats (event: open)
        // Version            v=1
        // Events             t=event&ec=email&ea=open
        // Tracking ID        tid=UA-XXXXX-Y
        // Client ID          cid=[list_id]
        // User ID            uid=[recipient_id]
        // Campaign Source    cs=[list]
        // Campaign Name      cn=[message_id]
        // Campaign Medium    cm=email
        // Document Path      dp=/email/open/{_request_id}
        // Document Title     dt=[subject] The document title (&dt) should be the subject line of the email.
        // Document Encoding  de=UTF-8
        $ga_beacon = [
            'v' => 1, 't' => 'event', 'ec' => 'email', 'ea' => 'open',
            'tid' => $ga_vars['tracking_id'],
            // 'cid' => md5($message['list_id'].random_string()),
            // 'uid' => '{recipient_id}',
            'cs'  => $ga_vars['campaign_source'],
            'cn'  => $ga_vars['campaign_name'],
            'cm'  => $ga_vars['campaign_medium'],
            'dt'  => $message['subject'], 'de'  => 'UTF-8',
        ];
        $ga_beacon_url = 'https://www.google-analytics.com/collect?'.http_build_query($ga_beacon);
        $ga_beacon_url .= '&dp=/email/open/{_request_id}&cid={_request_id}&uid={_recipient_id}';
        $ga_beacon_html = '<img alt="GA" width="1px" height="1px" src="'.$ga_beacon_url.'">';

        $body_html = str_replace('</body>', $ga_beacon_html.'</body>', $body_html, $replace_count);
        if (!$replace_count) $body_html .= $ga_beacon_html;

        $dom = HtmlDomParser::str_get_html($body_html);

        // 3. a.target=_blank
        $a_href_list = [];
        foreach($dom->find('a') as $a)
        {
            $a_href_list[] = $a->href;
            $a->target = '_blank';
        }

        $img_src_list = [];
        foreach($dom->find('img') as $img) $img_src_list[] = $img->src;

        $body_html = $dom->innertext;

        // 4. minify html
        $this->CI->load->library('composer/lib_html_minifier');
        $body_html = $this->CI->lib_html_minifier->process($body_html);

        // 5. inline css
        $this->CI->load->library('composer/lib_css_to_inline');
        $body_html = $this->CI->lib_css_to_inline->convert($body_html);

        // 6. add <title>{_subject}</title>
        $body_html = str_replace('</head>', '<title>{_subject}</title>'.'</head>', $body_html);

        // 7. restore href (since urls are encoded by dom in css inline)
        //    {_unsubscribe_link} => %7B_unsubscribe_link%7D
        $dom = HtmlDomParser::str_get_html($body_html);
        $count = 0;
        foreach($dom->find('a') as $a)
        {
            $a_href = $a_href_list[ $count ];

            switch ($a_href) {
                case '{_unsubscribe_link}':
                case '{_web_version_link}':
                case '{_campaign_archive_link}': break;
                
                default:
                    $ga_click_query = '?'.http_build_query($ga_hyperlink);

                    $a_href = str_replace('?', $ga_click_query.'&', $a_href, $replace_count);
                    if (!$replace_count) $a_href .= $ga_click_query;
                    break;
            }

            $a->href = $a_href;
            $count += 1;
        }

        $count = 0;
        foreach($dom->find('img') as $img) { $img->src = $img_src_list[ $count ]; $count += 1; }

        $body_html = $dom->innertext;

        return compact('body_html', 'body_text');
    }

    function add_request($message_id)
    {
        $this->CI->load->library('lib_request');

        $recipient_id = $this->CI->input->post('recipient_id');
        if (empty($recipient_id))
        {
            $this->error = ['status' => 401, 'message' => 'missing parameter recipient_id'];
            return NULL;
        }

        $to_name = $this->CI->input->post('to_name');

        if (is_null($to_email = valid_email($this->CI->input->post('to_email'))))
        {
            $this->error = ['status' => 401, 'message' => 'invalid email address in to_email'];
            return NULL;
        }

        $pseudo_vars = $this->CI->input->post('pseudo_vars');
        
        $message = $this->CI->model_message->get($message_id);
        if ($message['type'] != 'transactional')
        {
            $this->error = ['status' => 401, 'message' => 'the message type is not transactional'];
            return NULL;
        }

        $this->CI->load->library('lib_recipient');
        $recipient = $this->CI->lib_recipient->get($message['list_id'], $recipient_id, $to_name, $to_email);

        if (is_null($request_id = $this->CI->lib_request->add(
            $message_id, $recipient['auto_recipient_id'], $to_name, $to_email, $pseudo_vars)))
        {
            $this->error = $this->CI->lib_request->get_error_message();
            return NULL;
        }

        return ['request_id' => $request_id];
    }

    function get_campaign_archive($list_id, $count = 9)
    {
        return $this->CI->model_message->get_campaign_archive($list_id, $count);
    }
}