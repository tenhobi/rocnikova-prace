<?php

/**
 * Class EditorController Takes care about editor page and editing articles.
 */
class EditorController extends Controller
{
    /**
     * @param $parameters
     */
    public function processAdmin($parameters)
    {
        $this->checkUser(false);

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
            $userManager = new UserManager();
            $user = $userManager->getUser();

            $keys = array('title', 'content', 'url', 'description');
            $article = array_intersect_key($_POST, array_flip($keys));
            $article['author_id'] = $user['users_id'];
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