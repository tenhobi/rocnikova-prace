<?php

class RouterController extends Controller
{
    protected $controler;

    function process($parameters)
    {
        $parsedURL = $this->parseURL($parameters[0]);
        $controllerClass = $this->dashesToCamelCase(
            //array_shift($parsedURL)
            $parsedURL[0]
            . "Controller");

        echo($controllerClass);
        echo('<br />');
        print_r($parsedURL);
    }

    private function parseURL($url)
    {
        $parsedURL = parse_url($url)["path"];
        $parsedURL = ltrim($parsedURL, "/");
        $parsedURL = trim($parsedURL);

        $partedPath = explode("/", $parsedURL);
        return $partedPath;
    }

    private function dashesToCamelCase($str){
        $str = str_replace("-", " ", $str);
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        return $str;
    }
}