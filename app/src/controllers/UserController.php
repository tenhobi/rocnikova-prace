<?php

class UserController extends Controller
{
    public function process($parameters)
    {
        $this->data = array(
            'user' => array()
        );

        $userManager = new UserManager();
        $articleManager = new ArticleManager();

        $user = $userManager->getUserByNick($parameters[1]);
        $host = $userManager->getUser();

        $articles = $articleManager->getArticlesById($user['users_id']);

        if (empty($user))
            $this->redirect(Url::getAlias('error'));

        $this->head = array
        (
            'title' => 'Profil uživatele ' . $user['nickname'],
            'description' => 'Profil uživatele blogu.'
        );
        $this->data['user'] = $user;
        $this->data['host'] = $host;
        $this->data['articles'] = $articles;
        $this->data['admin'] = $host['admin'];
        $this->view = 'user';
    }
}