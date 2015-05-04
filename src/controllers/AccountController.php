<?php

class AccountController extends Controller
{

    public function processAdmin()
    {
        $this->checkUser(false);

        $userManager = new UserManager();
        $user = $userManager->getUser();

        if ($_POST)
        {
            try
            {
                $keys = array('nickname', 'description', 'motto', 'website', 'facebook', 'twitter', 'googleplus');
                $info = array_intersect_key($_POST, array_flip($keys));
                $userManager->saveInfo($user['users_id'], $info);
                $userManager->setUser($info);
                $this->addNotice('Informace byly úspěšně uloženy.');
                $this->redirect(Url::getAlias('admin') . '/' . Url::getAlias('account'));
            }
            catch (UserError $error)
            {
                $this->addNotice($error->getMessage());
            }
        }

        $this->data['user'] = $user;

        $this->head['title'] = 'Správa účtu';
        $this->view = 'account';
    }
}