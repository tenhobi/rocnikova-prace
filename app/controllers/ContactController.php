<?php

class ContactController extends Controller
{
    public function process($parameters)
    {
        $this->head = array(
            'title' => 'Kontaktní formulář',
            'keywords' => 'kontakt, email, formulář',
            'description' => 'Kontaktní formulář našeho webu.'
        );

        if (isset($_POST['email']))
        {
            if ($_POST['year'] == date("Y"))
            {
                $mailSender = new MailSender();
                $mailSender->send("no-reply@honzabittner.cz", "No Reply from Honza Bittner", $_POST['msg'], $_POST['email']);
            }
        }

        $this->view = 'contact';
    }
}