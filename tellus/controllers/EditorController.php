<?php

/**
 * Class EditorController Takes care about editor page and editing articles.
 */
class EditorController extends Controller
{
    public function process($parameters)
    {
        // $parameters[0] - controller
        // $parameters[1] - article
        // $parameters[2] - command

        if (!empty($parameters[0]) && !Url::isInAdmin($parameters))
            $this->redirect(Url::getAlias('admin') . '/' . Url::getAlias('editor'));

        $this->checkUser(true);
        $this->head['title'] = 'Editor článků';

        $articleManager = new ArticleManager();

        $article = array(
            'articles_id' => '',
            'title' => '',
            'content' => '',
            'url' => '',
            'description' => ''
        );

        if ($_POST)
        {
            $keys = array('title', 'content', 'url', 'description');
            $article = array_intersect_key($_POST, array_flip($keys));
            $articleManager->saveArticle($_POST['articles_id'], $article);
            $this->addNotice('Článek byl úspěšně uložen.');
            $this->redirect(Url::getAlias('article') . '/' . $article['url']);
        }
        else if (!empty($parameters[2]))
        {
            $loadedArticle = $articleManager->getArticle($parameters[2]);

            if ($loadedArticle)
                $article = $loadedArticle;
            else
                $this->addNotice('Článek nebyl nalezen');
        }

        $this->data['article'] = $article;

        $this->view = 'editor';
    }
}