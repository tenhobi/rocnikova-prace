<?php

class Url
{
    private static $urls = array();
    private static $commands = array();
    private static $admin = array();

    public static function getController($alias)
    {
        return array_flip(self::$urls)[$alias];
    }

    public static function getAlias($controller)
    {
        return self::$urls[$controller];
    }

    public static function getCommand($alias)
    {
        return self::$commands[$alias];
    }

    public static function init()
    {
        self::$urls = array();
        self::$commands = array();
        self::$admin = array();

        foreach (self::gerUrlRecord() as $row)
        {
            self::$urls[$row['controller']] = $row['alias'];

            if ($row['admin'] == 1)
                self::$admin[] = $row['alias'];
        }

        foreach (self::getCommandRecord() as $row)
        {
            self::$commands[$row['command']] = $row['alias'];
        }
    }

    private static function gerUrlRecord()
    {
        $record = Db::queryAll('
            SELECT `controller`, `alias`, `admin`
            FROM `url`
        ');
        return $record;
    }

    private static function getCommandRecord()
    {
        $record = Db::queryAll('
            SELECT `command`, `alias`
            FROM `url_commands`
        ');
        return $record;
    }
}