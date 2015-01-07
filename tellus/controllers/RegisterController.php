<?php

/**
 * Class RegisterController Takes care about register page and user's registration.
 */
class RegisterController extends Controller
{
    public function process($parameters)
    {
        if (!empty($parameters[0]) && !Url::isInAdmin($parameters))
            $this->redirect(Url::getAlias('admin') . '/' . Url::getAlias('register'));

        $this->head['title'] = 'Registrace';

        if ($_POST)
        {
            $recaptcha = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LeSJAATAAAAAJg4ySI4sHuhatGDre7Fk3cdV0W6&response=' . $_POST['g-recaptcha-response']));
            if ($recaptcha->{'success'} == 'true')
            {
                try
                {
                    $userManager = new UserManager();
                    $userManager->register($_POST['nickname'], $_POST['password']);
                    $userManager->logIn($_POST['nickname'], $_POST['password']);
                    $this->addNotice('Byl jste úspěšně zaregistrován.');
                    $this->redirect(Url::getAlias('admin'));
                }
                catch (UserError $error)
                {
                    $this->addNotice($error->getMessage());
                }
            }
            else
            {
                $this->addNotice('ReCaptcha vás nevyhodnotil jako člověka.');
            }
        }
        $this->view = 'register';
    }
}