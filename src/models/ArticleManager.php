<?php

class ArticleManager
{

    public function getArticle($url)
    {
        return Db::queryOne('
            SELECT a.`articles_id`, a.`author_id`, a.`title`, a.`content`, a.`url`, a.`description`, a.`keywords`, `u`.`nickname`, u.`url` as user_url, u.`users_id`
            FROM `articles` as a
            LEFT JOIN `users` as u
            ON a.`author_id` = u.`users_id`
            WHERE a.`url` = ?
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
            SELECT a.`author_id`, a.`articles_id`, a.`title`, a.`url`, a.`description`, u.`nickname`, u.`url` as user_url
            FROM `articles` as a
            LEFT JOIN `users` as u
            ON a.`author_id` = u.`users_id`
            WHERE `author_id` = ?
            ORDER BY `articles_id` DESC
        ', array($id));
    }

    public function saveArticle($id, $article)
    {
        if (!$id)
        {
            try
            {
                Db::insert('articles', $article);
            }
            catch (PDOException $error)
            {
                throw new UserError('Článek s touto url pravděpodobně již existuje.');
            }
        }
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