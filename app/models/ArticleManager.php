<?php

class ArticleManager
{

    public function getArticle($url)
    {
        return Db::queryOne
        ('
            SELECT `articles_id`, `title`, `content`, `url`, `description`, `keywords`
            FROM `articles`
            WHERE `url` = ?
        ', array($url));
    }

    public function getArticles()
    {
        return Db::queryAll
        ('
            SELECT `articles_id`, `title`, `url`, `description`
            FROM `articles`
            ORDER BY `articles_id` DESC
        ');
    }

}