<?php
session_start();

class PasswordUtilities
{
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function generateRandomString($length = 10, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function checkPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    public static function getUserHashedPassword($username)
    {
        // Retrieve the user's hashed password from the database based on the provided username
        // Replace this with your actual implementation
        $hashedPassword = ''; // Replace this line with your database query to retrieve the hashed password

        return $hashedPassword;
    }

    public static function loginUser($username, $password)
    {
        // Retrieve the user's hashed password from the database based on the provided username
        $hashedPassword = self::getUserHashedPassword($username);

        // Verify the provided password against the hashed password
        if (self::verifyPassword($password, $hashedPassword)) {
            // Password is correct, log in the user
            $_SESSION['username'] = $username;
            return true;
        } else {
            // Password is incorrect
            return false;
        }
    }

    public static function logoutUser()
    {
        // Destroy the session and log out the user
        session_destroy();
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

// Example usage:
// if (isset($_POST['login'])) {
//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     if (PasswordUtilities::loginUser($username, $password)) {
//         // User logged in successfully, redirect to the home page
//         header('Location: index.php');
//         exit;
//     } else {
//         // Invalid username or password, display an error message
//         $errorMessage = 'Invalid username or password';
//     }
// }
