<?php
mb_internal_encoding("UTF-8");
spl_autoload_register("autoLoad");

function autoLoad($class){
    if (preg_match("/Controller$/", $class))
        require("controllers/" . $class . ".php");
    else
        require("models/" . $class . ".php");
}

$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));