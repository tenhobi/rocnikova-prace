<?php

/**
 * Class RouterController Takes care about routing whole page and selecting right specific controller.
 */
class RouterController extends Controller
{

    /**
     * @var Controller Protect Controller instance for print.
     */
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

        if ($controllerClass == 'admin')
            $this->controller->data['notices'] = $this->getNotices();
        else
            $this->data['notices'] = $this->getNotices();

        $this->view = 'layout';

    }

    /**
     * Parse url to wanted form of url in array.
     *
     * @param array $url Array with page url.
     *
     * @return array Returns parsed and parted array with url.
     */
    private function parseURL($url)
    {
        $parsedURL = parse_url($url)['path'];
        $parsedURL = ltrim($parsedURL, '/');
        $parsedURL = trim($parsedURL);

        $partedPath = explode('/', $parsedURL);
        return $partedPath;
    }
}