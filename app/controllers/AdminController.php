<?php

class AdminController extends Controller
{
    public function process($parameters)
    {
        $this->checkUser();
        $this->head['title'] = 'Přihlášení';
        $userManager = new UserManager();
        if (!empty($parameters[0]) && $parameters[0] == 'logout')
        {
            $userManager->logOut();
            $this->redirect('login');
        }
        $user = $userManager->getUser();
        $this->data['first_name'] = $user['first_name'];
        $this->data['admin'] = $user['admin'];
        $this->view = 'admin';
    }
}