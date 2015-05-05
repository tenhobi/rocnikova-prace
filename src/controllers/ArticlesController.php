<?php

class ArticlesController extends Controller
{

    public function process($parameters)
    {
        $articleManager = new ArticleManager();
        $userManager = new UserManager();
        $user = $userManager->getUser();

        $this->data = array(
            'admin' => false,
            'access' => false,
            'heading' => '',
            'articles' => array()
        );

        $this->data['heading'] = "Výpis článků";
        $this->head = array
        (
            'title' => 'Výpis článků',
            'description' => 'Výpis všech článků na webu podle data.'
        );
        $articles = $articleManager->getArticles();
        $this->data['articles'] = $articles;
        $this->data['admin'] = $user && $user['admin'];
        $this->data['user'] = $user;
        $this->view = 'articles';
    }

    public function processAdmin($parameters)
    {
        $this->checkUser(false);

        $articleManager = new ArticleManager();
        $userManager = new UserManager();

        $user = $userManager->getUser();
        $articles = $articleManager->getArticlesById($user['users_id']);

        $this->data['admin'] = $user && $user['admin'];
        $nickname = $user['nickname'];

        $this->data['articles'] = $articles;
        $this->data['access'] = true;
        $this->data['heading'] = "Výpis článků uživatele $nickname";

        $this->head = array
        (
            'title' => "Výpis článků uživatele $nickname",
            'description' => 'Výpis všech článků na webu podle data.'
        );

        $this->view = 'articles';
    }
}