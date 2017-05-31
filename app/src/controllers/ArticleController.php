<?php

/**
 * Class ArticleController Takes care about articles and their print.
 */
class ArticleController extends Controller
{

    public function process($parameters)
    {
        $articleManager = new ArticleManager();
        $userManager = new UserManager();
        $user = $userManager->getUser();

        $this->data = array(
            'admin' => $user && $user['admin'],
            'access' => $user,
            'heading' => '',
            'articles' => array()
        );

        if (!empty($parameters[2]) && ($parameters[2] == Url::getCommand('delete')))
        {
            $this->checkUser(true);
            $articleManager->deleteArticle($parameters[1]);
            $this->redirect(Url::getAlias('article'));
            $this->data['heading'] = "Výpis článků";
        }
        else if (!empty($parameters[1]))
        {
            $article = $articleManager->getArticle($parameters[1]);

            if (!$article)
                $this->redirect(Url::getAlias('error'));

            $this->head = array(
                'title' => $article['title'],
                'description' => $article['description']
            );

            $this->data['article'] = $article;

            $this->view = 'article';
        }
        else
        {
            $this->redirect(Url::getAlias('articles'));
        }

    }

    public function processAdmin($parameters)
    {
        $this->checkUser(true);

        $articleManager = new ArticleManager();

        if (!empty($parameters[3]) && ($parameters[3] == Url::getCommand('delete')))
        {
            $articleManager->deleteArticle($parameters[2]);
        }

        $this->redirect(Url::getAlias('articles'));
    }
}