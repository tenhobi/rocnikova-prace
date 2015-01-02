<?php

class UserManager
{
    public function getImprint($password)
    {
        $salt = 'fd16sdfd2ew#$%';
        return hash('sha256', $password . $salt);
    }

    public function register($name, $password, $passwordTest, $year)
    {
        if ($year != date('Y'))
            throw new UserError('Chybně vyplněný antispam.');

        if ($password != $passwordTest)
            throw new UserError('Hesla nesouhlasí.');

        $user = array(
            'first_name' => $name,
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

    public function logIn($name, $password)
    {
        $user = Db::queryOne('
            SELECT `users_id`, `first_name`, `role` as `admin`
            FROM `users`
            WHERE `first_name` = ? AND `password` = ?
        ', array($name, $this->getImprint($password)));

        if (!$user)
            throw new UserError('Neplatné jméno nebo heslo.');

        $_SESSION['user'] = $user;
    }

    public function logOut()
    {
        unset($_SESSION['user']);
    }

    public function getUser()
    {
        if (isset($_SESSION['user']))
            return $_SESSION['user'];
        return null;
    }

}