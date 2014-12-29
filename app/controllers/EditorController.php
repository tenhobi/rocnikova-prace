<?php

class EditorController extends Controller
{
    public function process($parameters)
    {
        $this->head['title'] = 'Editor článků';

        $articleManager = new ArticleManager();

        $article = array(
            'articles_id' => '',
            'title' => '',
            'content' => '',
            'url' => '',
            'description' => '',
            'keywords' => '',
        );

        if ($_POST)
        {
            $keys = array('title', 'content', 'url', 'description', 'keywords');
            $article = array_intersect_key($_POST, array_flip($keys));
            $articleManager->saveArticle($_POST['articles_id'], $article);
            $this->addNotice('Článek byl úspěšně uložen.');
            $this->redirect('article/' . $article['url']);
        }
        else if (!empty($parameters[0]))
        {
            $loadedArticle = $articleManager->getArticle($parameters[0]);

            if ($loadedArticle)
                $article = $loadedArticle;
            else
                $this->addNotice('Článek nebyl nalezen');
        }

        $this->data['article'] = $article;

        $this->view = 'editor';
    }
}