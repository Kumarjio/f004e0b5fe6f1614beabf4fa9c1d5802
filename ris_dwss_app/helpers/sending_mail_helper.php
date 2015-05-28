<?php

if (!function_exists('send_mail')) {

    function send_mail($options) {

        $ci = get_instance();

        $config['protocol'] = $ci->config->item('protocol');
        if ((int)$ci->config->item('smtp_port') !== 0) {
            $config['smtp_port'] =  (int)$ci->config->item('smtp_port');
        }
        $config['smtp_host'] = $ci->config->item('smtp_host');
        $config['smtp_user'] = $ci->config->item('smtp_user');
        $config['smtp_pass'] = $ci->config->item('smtp_pass');
        $config['mailtype'] = 'html';
        $config['charset']='utf-8';

        $ci->load->library('email', $config);
        $ci->email->set_newline("\r\n");
        $ci->email->from($ci->config->item('smtp_user'), $ci->config->item('en_app_name'));
        $ci->email->to($options['tomailid']);
        $ci->email->subject($options['subject']);
        $ci->email->message($options['message']);

        if (isset($options['cc']))
            $ci->email->bcc($options['cc']);

        if (isset($options['attachement']))
            $ci->email->attach($options['attachement']);

        $check = $ci->email->send();

        if (!$check) {
            /*$header = "From: ". $ci->config->item('app_name') ." <". $ci->config->item('smtp_user')."> \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            $return  = mail($options['tomailid'],$options['subject'],$options['message'],$header);
            return $return; */
            echo  $ci->email->print_debugger();
        } else {
            return TRUE;
        }
    }

}

if (!function_exists('sendSMS')) {

    function sendSMS($mobile, $msg, $user = 'WEBINQ') {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_URL, 'http://bhashsms.com/api/sendmsg.php?user=Daliaweb&pass=Dalia58&sender='. $user .'&phone=' . $mobile . '&text=' . urlencode($msg) . '&priority=ndnd&stype=normal');
        $check = curl_exec($curl);
        curl_close($curl);

        return 1;

    }
}

?>