<?php

class UserController
{
    public function actionLogin()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $userId = User::checkUserData($login, $password);

        if($userId) {
            User::auth($userId); // set user as logged, if data is valid
            return true;
        }

        return false;
    }

    public function actionLogout()
    {
        unset($_SESSION['user']);
        setcookie('name', null, -1);
        setcookie('email', null, -1);
        return true;
    }
}
