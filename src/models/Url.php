<?php

/**
 * Class Url Manage url addresses.
 */
class Url
{
    /**
     * @var array Array of 'controller' => 'alias'.
     */
    private static $urls = array();
    
    /**
     * @var array Array of 'alias' => 'command'.
     */
    private static $commands = array();

    /**
     * Returns controller name from aliases name.
     *
     * @param string $alias Name of alias in lowercase.
     *
     * @return string
     */
    public static function getController($alias)
    {
        return array_flip(self::$urls)[$alias];
    }

    /**
     * Returns alias name from controller's name.
     *
     * @param string $controller Name of controller in lowercase.
     *
     * @return string
     */
    public static function getAlias($controller)
    {
            return self::$urls[$controller];
    }

    /**
     * Returns command from command's alias.
     *
     * @param string $alias Name of command's alias.
     *
     * @return string
     */
    public static function getCommand($alias)
    {
        return self::$commands[$alias];
    }

    /**
     * Sets all needed for url manager.
     */
    public static function init()
    {
        self::$urls = array();
        self::$commands = array();

        foreach (self::getUrlRecord() as $row)
        {
            self::$urls[$row['controller']] = $row['alias'];

        }

        foreach (self::getCommandRecord() as $row)
        {
            self::$commands[$row['command']] = $row['alias'];
        }
    }

    /**
     * Gets url record from database.
     * @return array
     */
    private static function getUrlRecord()
    {
        $record = Db::queryAll('
            SELECT `controller`, `alias`
            FROM `url`
        ');
        return $record;
    }

    /**
     * Gets command's aliases from database.
     * @return array
     */
    private static function getCommandRecord()
    {
        $record = Db::queryAll('
            SELECT `command`, `alias`
            FROM `url_commands`
        ');
        return $record;
    }
}
