<?php

class ContactController extends Controller
{
    public function process($parameters)
    {
        $this->head = array
        (
            'title' => 'Kontaktní formulář',
            'description' => 'Kontaktní formulář našeho webu.',
            'keywords' => 'kontakt, email, formulář'
        );

        if ($_POST)
        {
            try
            {
                $mailSender = new MailSender();
                $mailSender->sendWithAntispam($_POST['year'], "no-reply@honzabittner.cz", "No Reply from Honza Bittner", $_POST['msg'], $_POST['email']);
                $this->addNotice('Email byl úspěšně odeslán');
                $this->redirect(Url::getAlias('contact'));
            }
            catch (UserError $error)
            {
                $this->addNotice($error->getMessage());
            }
        }

        $this->view = 'contact';
    }
}