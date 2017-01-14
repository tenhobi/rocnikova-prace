<?php

class MailSender{

    public function send($target, $subject, $message, $from)
    {
        $head = "From: $from";
        $head .= "\nMIME-Version: 1.0\n";
        $head .= "Content-Type: text/html; charset=\"utf-8\"\n";
        if(!mb_send_mail($target, $subject, $message, $head))
            throw new UserError('Email se nepodařilo odeslat.');
    }

    public function sendWithAntispam($year, $target, $subject, $message, $from)
    {
        if ($year != date("Y"))
            throw new UserError("Chybně vyplněný antispam.");
        $this->send($target, $subject, $message, $from);
    }

}