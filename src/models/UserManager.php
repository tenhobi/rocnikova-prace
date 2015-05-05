<?php

/**
 * Manager processes user interaction.
 * Class UserManager
 */
class UserManager
{
    const LOGIN_LENGTH = 3;
    const PASSWORD_LENGTH = 5;

    /**
     * Method returns hashed Imprint from password and salt
     *
     * @param $password string have to be >= 5
     *
     * @return string hashed password with salt
     */
    public function getImprint($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function getUrl($name)
    {
        $url = trim($name);
        $url = str_replace(' ', '', $url);
        $url = strtolower($url);
        return $url;
    }

    /**
     * User registration with insert into database.
     *
     * @param $login     string Name with more than 2 letters.
     * @param $password  string Password with more than 5 letters.
     *
     * @throws UserError
     */
    public function register($login, $password)
    {
        if (strlen($login) < self::LOGIN_LENGTH)
        {
            $length = self::LOGIN_LENGTH;
            throw new UserError("Příliš krátké jméno. Jméno musí mít alespoň $length znaků.");
        }

        if (strlen($password) < self::PASSWORD_LENGTH)
        {
            $length = self::PASSWORD_LENGTH;
            throw new UserError("Příliš krátké heslo. Heslo musí mít alespoň $length znaků.");
        }

        if (preg_match("/[^a-zA-Z0-9_-]+/", $login))
        {
            throw new UserError("Přezdívka může obsahovat pouze znaky a-z, A-Z, 0-9, _ a -.");
        }

        $user = array(
            'nickname' => $login,
            'password' => $this->getImprint($password, $login),
            'url' => $this->getUrl($login)
        );

        try
        {
            Db::insert('users', $user);
        }
        catch (PDOException $error)
        {
            throw new UserError('Uživatel s tímto jménem je již zaregistrovaný.');
        }
    }

    /**
     * Method for easy user log in and check with database record.
     *
     * @param $login     string User name.
     * @param $password  string User password.
     *
     * @throws UserError Invalid name or password.
     */
    public function logIn($login, $password)
    {
        $user = Db::queryOne('
            SELECT *
            FROM `users`
            WHERE `nickname` = ?
        ', array($login));

        if (!password_verify($password, $user['password']))
            throw new UserError('Neplatné jméno nebo heslo.');

        $_SESSION['user'] = $user;
    }

    /**
     * Method log outs user and clear user's info.
     */
    public function logOut()
    {
        unset($_SESSION['user']);
    }

    /**
     * Returns user's info.
     * @return $_SESSION['user'] If user is logged in.
     */
    public function getUser()
    {
        if (isset($_SESSION['user']))
            return $_SESSION['user'];
        return null;
    }

    public function getUsers()
    {
        return Db::queryAll('
            SELECT `users_id`, `nickname`, `url`, `description`, `admin`
            FROM `users`
            ORDER BY `nickname` ASC
        ');
    }

    public function getUserByNick($nick)
    {
        return Db::queryOne('
            SELECT `users_id`, `nickname`, `admin`, `url`, `description`, `motto`, `website`, `facebook`, `twitter`, `googleplus`
            FROM `users`
            WHERE `nickname` = ?
        ', array($nick));
    }

    public function saveInfo($id, $info)
    {
        if (preg_match("/[^a-zA-Z0-9_-]+/", $info['nickname']))
        {
            throw new UserError("Přezdívka může obsahovat pouze znaky a-z, A-Z, 0-9, _ a -.");
        }

        $info['url'] = $this->getUrl($info['nickname']);

        if ($id)
            Db::update('users', $info, 'WHERE users_id = ?', array($id));
        else
            throw new UserError('Informace se nepodařily aktualizovat.');
    }

    public function setUser($info)
    {
        if (isset($_SESSION['user']))
        {
            foreach ($info as $key => $value)
            {
                $_SESSION['user'][$key] = $value;
            }
        }
    }

    public function addToAdmin($nickname)
    {
        Db::update('users', array('admin' => 1), "WHERE `nickname` = ?", array($nickname));
    }

    public function removeFromAdmin($nickname)
    {
        Db::update('users', array('admin' => 0), "WHERE `nickname` = ?", array($nickname));
    }

}