<?php

class ArticleController extends Controller{

    public function process($parameters)
    {
        $articleManager = new ArticleManager();
        $userManager = new UserManager();
        $user = $userManager->getUser();
        $this->data['admin'] = $user && $user['admin'];

        if(!empty($parameters[1]) && $parameters[1] == 'delete')
        {
            $this->checkUser(true);
            $articleManager->deleteArticle($parameters[0]);
            $this->redirect('clanek');
        }
        else if(!empty($parameters[0]) )
        {
            $article = $articleManager->getArticle($parameters[0]);

            if(!$article)
                $this->redirect('error');

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