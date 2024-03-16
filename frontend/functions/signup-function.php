<?php
require_once(__DIR__ . '/../backend/bus/user_bus.php');
require_once(__DIR__ . '/../backend/model/user_model.php');
require_once(__DIR__ . '/../backend/services/password_utilities.php');
require_once(__DIR__ . '/../backend/services/validation.php');

function signup($username, $email, $password, $confirmPassword, $phone, $gender)
{
    if (UserBus::getInstance()->isUsernameTaken($username)) {
        return "Username is already taken";
    }

    if (UserBus::getInstance()->isEmailTaken($email)) {
        return "Email is already taken";
    }

    $password = PasswordUtilities::getInstance()->hashPassword($password);
    $confirmPassword = PasswordUtilities::getInstance()->hashPassword($confirmPassword);

    if ($password != $confirmPassword) {
        return "Passwords do not match. Please try again.";
    }

    if ($phone != null && !validation::getInstance()->isValidPhoneNumber($phone)) {
        return "Invalid phone number";
    }

    if ($gender != 'male' && $gender != 'female') {
        return "Invalid gender";
    } else if ($gender == 'male') {
        $gender = 1;
    } else {
        $gender = 0;
    }

    $name = "Customer";
    $image = null;
    $roleId = 0;
    $status = 'ACTIVE';
    $address = 'No address assigned';

    //check for successful signup:
    try {
        $user = new UserModel(0, $username, $password, $email, $name, $phone, $gender, $image, $roleId, $status, $address);
        UserBus::getInstance()->addModel($user);
        return "Signup successful";
    } catch (Exception $e) {
        // Handle error and display at frontend
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        return "Error occurred during signup";
    }
}
