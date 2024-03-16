<?php
session_start();

function signup($username, $email, $password)
{
    $username = $_POST['username'];
    if (UserBus::getInstance()->isUsernameTaken($username)) {
        return "Username is already taken";
    }

    $email = $_POST['email'];
    if (UserBus::getInstance()->isEmailTaken($email)) {
        return "Email is already taken";
    }

    $password = $_POST['password'];
    $password = PasswordUtilities::getInstance()->hashPassword($password);
    $confirmPassword = $_POST['confirmPassword'];
    $confirmPassword = PasswordUtilities::getInstance()->hashPassword($confirmPassword);

    if ($password != $confirmPassword) {
        return "Passwords do not match. Please try again.";
    }

    $phone = $_POST['phone'];
    if ($phone != null && !validation::getInstance()->isValidPhoneNumber($phone)) {
        return "Invalid phone number";
    }

    $gender = $_POST['gender'];
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
        UserBus::getInstance()->validateModel($user);
        UserBus::getInstance()->addModel($user);
        return "Signup successful";
    } catch (Exception $e) {
        // Handle error and display at frontend
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        return "Error occurred during signup";
    }
}
session_abort();