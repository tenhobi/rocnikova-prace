<?php

/**
 * Class Controller Abstract controller which store all abstract and shared methods and variables.
 */
abstract class Controller
{
    /**
     * @var array Data for print into web page.
     */
    protected $data = array();

    /**
     * @var string Current view to print.
     */
    protected $view = "";

    /**
     * @var array Data for head of HTML.
     */
    protected $head = array
    (
        'title' => '',
        'description' => '',
        'keywords' => ''
    );

    /**
     * @param array $parameters Url parts for process with Controller.
     */
    public function process($parameters)
    {
        $this->redirect(Url::getAlias('error'));
    }

    public function processAdmin($parameters)
    {
        $this->redirect(Url::getAlias('error'));
    }

    /**
     * Prints current view with extracted data.
     */
    public function printView()
    {
        if ($this->view)
        {
            extract($this->protect($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("views/$this->view.phtml");
        }
    }

    /**
     * @param string $url Url for redirect.
     */
    public function redirect($url)
    {
        $url = trim($url);
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    /**
     * @param array|string $x Variable for protect html special chars.
     *
     * @return array|null|string
     */
    public function protect($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x))
        {
            foreach ($x as $k => $v)
            {
                $x[$k] = $this->protect($v);
            }
            return $x;
        }
        else
            return $x;
    }

    /**
     * @param string $text Add text to notice list.
     */
    public function addNotice($text)
    {
        if (isset($_SESSION['notices']))
            $_SESSION['notices'][] = $text;
        else
            $_SESSION['notices'] = array($text);
    }

    /**
     * @return array Returns array with notices.
     */
    public function getNotices()
    {
        if (isset($_SESSION['notices']))
        {
            $notices = $_SESSION['notices'];
            unset($_SESSION['notices']);
            return $notices;
        }
        else
            return array();
    }

    /**
     * @param bool $admin Says if user must be admin or not.
     */
    public function checkUser($admin = false)
    {
        $userManager = new UserManager();
        $user = $userManager->getUser();
        if (!$user)
        {
            $this->addNotice('Nedostatečná oprávnění.');
            $this->redirect(Url::getAlias('admin') . '/' . Url::getAlias('login'));
        }
        else if (($admin && !$user['admin']))
        {
            $this->addNotice('Nedostatečná oprávnění.');
            $this->redirect(Url::getAlias('admin') . '/' . Url::getAlias('account'));
        }
    }

    /**
     * Rewrites $str with dashes to CamelCase notation.
     *
     * @param string $str String for rewrite.
     *
     * @return string String in CamelCase notation.
     */
    public function dashesToCamelCase($str)
    {
        $str = str_replace('-', ' ', $str);
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        return $str;
    }
}