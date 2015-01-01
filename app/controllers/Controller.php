<?php

abstract class Controller
{
    protected $data = array();

    protected $view = "";

    protected $head = array
    (
        'title' => '',
        'description' => '',
        'keywords' => ''
    );

    abstract function process($parameters);

    public function printView()
    {
        if($this->view){
            extract($this->protect($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("views/" . $this->view . ".phtml");
        }
    }

    public function redirect($url)
    {
        $url = trim($url);
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    public function protect($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x))
        {
            foreach($x as $k => $v)
            {
                $x[$k] = $this->protect($v);
            }
            return $x;
        }
        else
            return $x;
    }

    public function addNotice($text)
    {
        if(isset($_SESSION['notices']))
            $_SESSION['notices'][] = $text;
        else
            $_SESSION['notices'] = array($text);
    }

    public function getNotices()
    {
        if(isset($_SESSION['notices']))
        {
            $notices = $_SESSION['notices'];
            unset($_SESSION['notices']);
            return $notices;
        }
        else
            return array();
    }

    /*
    public function checkUser($role = 0){
        // role 0: user
        // role 1: moderator
        // role 2: admin
        $userManager = new UserManager();
        $user = $userManager->getUser();

    }*/

    public function checkUser($admin = false)
    {
        $userManager = new UserManager();
        $user = $userManager->getUser();
        if(!$user || ($admin && !$user['admin'])){
            $this->addNotice('Nedostatečná oprávnění.');
            $this->redirect(Url::getAlias('login'));
        }
    }
}