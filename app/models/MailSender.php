<?php

class MailSender{

    public function send($target, $subject, $message, $from){
        $head = "From: $from";
        $head .= "\nMIME-Version: 1.0\n";
        $head .= "Content-Type: text/html; charset=\"utf-8\"\n";
        return mb_send_mail($target, $subject, $message, $head);
    }

}