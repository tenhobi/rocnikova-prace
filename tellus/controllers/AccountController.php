<?php

class AccountController extends Controller
{

    /**
     * @param array $parameters Url parts for process with Controller.
     */
    function process($parameters)
    {
        if (!empty($parameters[0]) && !Url::isInAdmin($parameters))
            $this->redirect(Url::getAlias('admin') . '/' . Url::getAlias('login'));

        $this->checkUser(true);

        $userManager = new UserManager();
        $user = $userManager->getUser();

        if ($_POST)
        {
            try
            {
                $keys = array('nickname', 'content', 'url', 'description');
                $info = array_intersect_key($_POST, array_flip($keys));
                $userManager->saveInfo($user['users_id'], $info);
                $this->addNotice('Informace byly uloženy. Přihlašte se prosím znova.');
                $userManager->logOut();
                $this->redirect(Url::getAlias('admin') . '/' . Url::getAlias('login'));
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