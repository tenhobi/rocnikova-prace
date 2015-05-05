<?php

class ArticleManager
{

    public function getArticle($url)
    {
        return Db::queryOne('
            SELECT `articles_id`, `author_id`, `title`, `content`, `url`, `description`, `keywords`
            FROM `articles`
            WHERE `url` = ?
        ', array($url));
    }

    public function getArticles()
    {
        return Db::queryAll('
            SELECT a.`articles_id`, a.`author_id`, a.`title`, a.`url`, a.`description`, u.`nickname`, u.`url` as user_url
            FROM `articles` as a
            LEFT JOIN `users` as u
            ON a.`author_id` = u.`users_id`
            ORDER BY `a`.`articles_id` DESC
        ');
    }

    public function getArticlesById($id)
    {
        return Db::queryAll('
            SELECT `author_id`, `articles_id`, `title`, `url`, `description`
            FROM `articles`
            WHERE `author_id` = ?
            ORDER BY `articles_id` DESC
        ', array($id));
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