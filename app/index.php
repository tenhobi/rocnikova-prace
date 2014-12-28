<?php
session_start();
mb_internal_encoding("UTF-8");
spl_autoload_register("autoLoad");

function autoLoad($class){
    if (preg_match("/Controller$/", $class))
        require("controllers/" . $class . ".php");
    else
        require("models/" . $class . ".php");
}


Db::login("127.0.0.1", "root", "", "blog");
//Db::login("","HB_rocnikovka", "rocnikovy-projekt", "HB_rocnikovka");

$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));
$router->printView();