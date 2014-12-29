<?php

class RegisterController extends Controller
{
    public function process($parameters)
    {
        $this->head['title'] = 'Registrace';
        if ($_POST)
        {
            try
            {
                $userManager = new UserManager();
                $userManager->register($_POST['first_name'], $_POST['password'], $_POST['password_test'], $_POST['year']);
                $userManager->logIn($_POST['first_name'], $_POST['password']);
                $this->addNotice('Byl jste úspěšně zaregistrován.');
                $this->redirect('admin');
            }
            catch (UserError $error)
            {
                $this->addNotice($error->getMessage());
            }
        }
        $this->view = 'register';
    }
}