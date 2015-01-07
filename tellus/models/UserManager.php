<?php

/**
 * Manager processes user interaction.
 * Class UserManager
 */
class UserManager
{
    const LOGIN_LENGTH = 2;
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
        $salt = 'fd16sdfd2ew#$%';
        return hash('sha256', $password . $salt);
    }

    /**
     * User registration with insert into database.
     *
     * @param $login     string Name with more than 2 letters.
     * @param $password  string Password with more than 5 letters.
     * @param $year      string Simple actual-year anti spam.
     *
     * @throws UserError
     */
    public function register($login, $password)
    {
        if (strlen($login) <= self::LOGIN_LENGTH)
        {
            $length = self::LOGIN_LENGTH + 1;
            throw new UserError("Příliš krátké jméno. Jméno musí mít alespoň $length znaků.");
        }

        if (strlen($password) <= self::PASSWORD_LENGTH)
        {
            $length = self::PASSWORD_LENGTH + 1;
            throw new UserError("Příliš krátké heslo. Heslo musí mít alespoň $length znaků.");
        }

        $user = array(
            'nickname' => $login,
            'password' => $this->getImprint($password),
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
            WHERE `nickname` = ? AND `password` = ?
        ', array($login, $this->getImprint($password)));

        if (!$user)
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

    public function saveInfo($id, $info)
    {
        if ($id)
            Db::update('users', $info, 'WHERE users_id = ?', array($id));
        else
            throw new UserError('Informace se nepodařily aktualizovat.');
    }

}