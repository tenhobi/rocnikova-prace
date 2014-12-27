<?php

class ArticleController extends Controller{

    public function process($parameters){
        $articleManager = new ArticleManager();

        if(!empty($parameters[0])){
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
        }else{
            $articles = $articleManager->getArticles();
            $this->data['articles'] = $articles;
            $this->view = 'articles';
        }

    }

}