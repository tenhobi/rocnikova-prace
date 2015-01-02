<?php

class AdminController extends Controller
{
    public function process($parameters)
    {
        // $parameters[0] - admin
        // $parameters[1] - controller
        // $parameters[2] - command

        $this->checkUser();
        $userManager = new UserManager();

        if (!empty($parameters[1]) && ($parameters[1] == Url::getCommand('logout')))
        {
            $userManager->logOut();
            $this->redirect(Url::getAlias('login'));
        }

        $user = $userManager->getUser();
        $this->data['first_name'] = $user['first_name'];
        $this->data['admin'] = $user['admin'];
        $this->head['title'] = 'Administrace';

        $this->view = 'admin';

    }
}