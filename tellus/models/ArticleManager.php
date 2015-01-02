<?php

class ArticleManager
{

    public function getArticle($url)
    {
        return Db::queryOne('
            SELECT `articles_id`, `title`, `content`, `url`, `description`, `keywords`
            FROM `articles`
            WHERE `url` = ?
        ', array($url));
    }

    public function getArticles()
    {
        return Db::queryAll('
            SELECT `articles_id`, `title`, `url`, `description`
            FROM `articles`
            ORDER BY `articles_id` DESC
        ');
    }

    public function saveArticle($id, $article)
    {
        if (!$id)
            Db::insert('articles', $article);
        else
            Db::update('articles', $article, 'WHERE articles_id = ?', array($id));
    }

    public function deleteArticle($url)
    {
        Db::query('
                DELETE FROM articles
                WHERE url = ?
        ', array($url));
    }

}