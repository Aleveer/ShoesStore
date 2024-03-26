<?php
session_start();

class PasswordUtilities
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PasswordUtilities();
        }
        return self::$instance;
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function getUserHashedPassword($username)
    {
        // Retrieve the user's hashed password from the database based on the provided username
        // Replace this with your actual implementation
        $hashedPassword = ''; // Replace this line with your database query to retrieve the hashed password

        return $hashedPassword;
    }

    public static function isUserLoggedIn()
    {
        // Check if the user is logged in by checking the existence of the 'username' session variable
        return isset($_SESSION['username']);
    }

    public static function requireLoggedInUser()
    {
        // Redirect the user to the login page if they are not logged in
        if (!self::isUserLoggedIn()) {
            header('Location: login.php');
            exit;
        }
    }
}
