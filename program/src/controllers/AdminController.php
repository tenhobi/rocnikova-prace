<?php

/**
 * Class AdminController Takes care about admin page and environment.
 */
class AdminController extends Controller
{

    protected $subController;

    public function process($parameters)
    {
        // $parameters[0] - admin
        // $parameters[1] - controller
        // $parameters[2] - command

        // $this->checkUser();
        $userManager = new UserManager();

        if (empty($parameters[1]))
        {
            $this->redirect(Url::getAlias('admin') . '/' . Url::getAlias('account'));
        }
        else if (!empty($parameters[1]) && ($parameters[1] == Url::getCommand('logout')))
        {
            $userManager->logOut();
            $this->redirect(Url::getAlias('admin') . '/' . Url::getAlias('login'));
        }
        else if (!empty($parameters[1]))
        {
            $address = Url::getController($parameters[1]);

            if (!isset($address))
            {
                $this->redirect(Url::getAlias('error'));
            }

            $controllerClass = $this->dashesToCamelCase($address . 'Controller');

            if (file_exists("controllers/" . $controllerClass . ".php"))
                $this->subController = new $controllerClass;
            else
            {
                $this->redirect(Url::getAlias('error'));
            }

            $this->subController->processAdmin($parameters);
        }

        $user = $userManager->getUser();

        $this->data['nickname'] = $user['nickname'];
        $this->data['admin'] = $user['admin'];
        $this->data['userUrl'] = $user['url'];
        $this->data['access'] = isset($user);

        $this->head['title'] = $this->subController->head['title'];

        $this->view = 'admin';

    }
}