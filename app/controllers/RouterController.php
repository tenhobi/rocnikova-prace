<?php

class RouterController extends Controller
{

    protected $controller;

    function process($parameters)
    {
        $parsedURL = $this->parseURL($parameters[0]);

        if (empty($parsedURL[0]))
            $this->redirect(Url::getAlias('article') . "/uvod");

        $address = Url::getController($parsedURL[0]);

        if (!isset($address))
        {
            $this->redirect(Url::getAlias('error'));
        }

        $controllerClass = $this->dashesToCamelCase($address . 'Controller');

        if (file_exists("controllers/" . $controllerClass . ".php"))
            $this->controller = new $controllerClass;
        else
        {
            $this->redirect(Url::getAlias('error'));
        }

        $this->controller->process($parsedURL);

        $this->data['title'] = $this->controller->head['title'];
        $this->data['description'] = $this->controller->head['description'];
        $this->data['keywords'] = $this->controller->head['keywords'];
        $this->data['notices'] = $this->getNotices();

        if ($parsedURL[0] == Url::getAlias('admin'))
            $this->view = 'admin_layout';
        else
            $this->view = 'layout';

    }

    private function parseURL($url)
    {
        $parsedURL = parse_url($url)['path'];
        $parsedURL = ltrim($parsedURL, '/');
        $parsedURL = trim($parsedURL);

        $partedPath = explode('/', $parsedURL);
        return $partedPath;
    }

    private function dashesToCamelCase($str)
    {
        $str = str_replace('-', ' ', $str);
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        return $str;
    }


}