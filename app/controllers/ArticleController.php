<?php

class ArticleController extends Controller{

    public function process($parameters)
    {
        // $parameters[0] - controller
        // $parameters[1] - article
        // $parameters[2] - command

        $articleManager = new ArticleManager();
        $userManager = new UserManager();
        $user = $userManager->getUser();
        $this->data['admin'] = $user && $user['admin'];

        if(!empty($parameters[1]) && !empty($parameters[2]) && ($parameters[2] == Url::getCommand('delete')))
        {
            $this->checkUser(true);
            $articleManager->deleteArticle($parameters[1]);
            $this->redirect(Url::getAlias('article'));
        }
        else if(!empty($parameters[1]) )
        {
            $article = $articleManager->getArticle($parameters[1]);

            if(!$article)
                $this->redirect(Url::getAlias('error'));

            $this->head = array(
                'title' => $article['title'],
                'description' => $article['description'],
                'keywords' => $article['keywords']
            );

            $this->data['title'] = $article['title'];
            $this->data['content'] = $article['content'];

            $this->view = 'article';
        }
        else
        {
            $this->head = array
            (
                'title' => 'Výpis článků',
                'description' => 'Výpis všech článků na webu podle data.',
                'keywords' => 'clanky, vypis, vsechny'
            );
            $articles = $articleManager->getArticles();
            $this->data['articles'] = $articles;
            $this->view = 'articles';
        }

    }

}