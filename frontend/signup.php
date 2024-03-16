<?php
// Check if the sign-up form is submitted
// if ($_SERVER["REQUEST_METHOD" == 'POST']) {
//     echo "Form submitted";
//     print_r($_POST);
// }

include_once(__DIR__ . '/../frontend/functions/signup-function.php');
if (isset($_POST['Signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    // Call the signup function
    signup($username, $email, $password, $confirmPassword, $phone, $gender);
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- <link rel="stylesheet" href="assets/css/login.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <div id="signup-page" class="site">
        <div class="form-warp">
            <img src="assets/images/nike-af.jpeg" alt="background">
            <div class="LogOut">
                <h1>Sign up</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div>
                        <input type="text" id="username" name="username" placeholder="">
                        <label for="username">Username</label>
                        <i class="ri-user-line"></i>
                    </div>
                    <div>
                        <input type="password" id="password" name="password" placeholder="">
                        <label for="password">Password</label>
                        <i class="ri-lock-line"></i>
                    </div>
                    <div>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="">
                        <label for="password">Re-enter your password</label>
                        <i class="ri-lock-line"></i>
                    </div>
                    <div>
                        <input type="email" id="email" name="email" placeholder=" ">
                        <label for="email">Email (Required)</label>
                        <i class="ri-lock-line"></i>
                    </div>
                    <div>
                        <input type="phone" id="phone" name="phone" placeholder=" ">
                        <label for="phone">Phone Number (Optional)</label>
                        <i class="ri-lock-line"></i>
                    </div>
                    <div>
                        <label for="gender">Gender:</label>
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>
                    </div>
                    <div>
                        <button type="submit" name="signup">Signup</button>
                    </div>
                    <div class="split" style="margin-right: 20px;">
                        <a href="#">If you have an account, please log in!</a>
                        <a href="Login.html">Log in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>