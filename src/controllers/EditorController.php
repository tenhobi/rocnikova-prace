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

        $userManager = new UserManager();
        $user = $userManager->getUser();

        $article = array(
            'articles_id' => '',
            'author_id' => $user['users_id'],
            'title' => '',
            'content' => '',
            'url' => '',
            'description' => ''
        );

        if ($_POST)
        {
            $keys = array('author_id', 'title', 'content', 'url', 'description');
            $article = array_intersect_key($_POST, array_flip($keys));
            $articleManager->saveArticle($_POST['articles_id'], $article);
            $this->addNotice('Článek byl úspěšně uložen.');
            $this->redirect(Url::getAlias('article') . '/' . $article['url']);
        }
        else if (!empty($parameters[2]))
        {
            $loadedArticle = $articleManager->getArticle($parameters[2]);

            if ($loadedArticle){
                if ($loadedArticle['author_id'] == $user['users_id']){
                    $article = $loadedArticle;
                }
                else {
                    $this->addNotice('Na úpravu cizího článku nemáš práva!');
                }
            }
            else
                $this->addNotice('Článek nebyl nalezen.');
        }

        $this->data['article'] = $article;
        $this->data['admin'] = $user['admin'];

        $this->view = 'editor';
    }
}