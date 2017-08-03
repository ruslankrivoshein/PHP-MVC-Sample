<?php

class User
{
    // validation of authorization
    public static function checkUserData($login, $password)
    {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT id FROM users WHERE login = ? AND password = ?");
        $query->bind_param('ss', $login, $password);
        $query->execute();
        $query->bind_result($result);

        while ($query->fetch()) {
            if (isset($result)) {
                $db->close();
                return $result;
            }
        }

        $db->close();
        return false;
    }

    // set the user as logged
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    // checking user's role
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    // also checking session if user is admin
    public static function isAdmin()
    {
        if (isset($_SESSION['user'])) {
            $db = Database::getConnection();
            $query = $db->prepare("SELECT role FROM users WHERE id = ?");
            $query->bind_param('d', $_SESSION['user']);
            $query->execute();
            $query->bind_result($result);

            while ($query->fetch()) {
                if ($result == "admin") {
                    $db->close();
                    return true;
                }
            }
            $db->close();
        }

        return false;
    }

    public static function getUserById($id)
    {
        $db = Database::getConnection();

        $query = $db->prepare("SELECT name, email FROM users WHERE id = ?");
        $query->bind_param('d', $id);
        $query->execute();
        $query->bind_result($name, $email);

        while ($query->fetch()) {
            $db->close();
            return ['name' => $name, 'email' => $email];
        }

        $db->close();
        return null;
    }
}
