<!-- Đăng nhập tài khoản -->
<?php
// login.php
if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Đăng nhập'
];

// Đã nhúng file function.php bên index.php
layouts('header', $data);

// Kiểm tra trạng thái đăng nhập
if (isLogin()) {
    redirect('?module=indexphp&action=userhomepage');
}

if (isPost()) {
    $filterAll = filter();
    $response = ['success' => false, 'msg' => ''];

    if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
        // Check login
        $email = $filterAll['email'];
        $password = $filterAll['password'];

        // $userQuery = getRow("SELECT password, id FROM user WHERE email='$email'");
        $userQuery = UserBUS::getInstance()->getModelByField($email, 'email');
        if (!empty($userQuery)) {
            $passwordHash = $userQuery->getPassword();
            if (PasswordUtilities::getInstance()->verifyPassword($password, $passwordHash)) {
                // Password is valid, start the session and store the user's ID
                $_SESSION['userId'] = $userQuery['id'];
                $response['success'] = true;
                $response['msg'] = 'Login successful!';
            } else {
                $response['msg'] = 'Incorrect password!';
            }
        } else {
            $response['msg'] = 'Email does not exist!';
        }
    } else {
        $response['msg'] = 'Please enter email and password!';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>

<div class="row">
    <div class="col-4" style="margin:50px auto;">
        <h2 class="cw" style="text-align: center; text-transform: uppercase;">Đăng Nhập</h2>
        <?php if (!empty($msg)) {
            getMsg($msg, $msgType);
        } ?>
        <form action="" method="post">
            <div class="form-group mg-form">
                <label class="cw" for="">Email</label>
                <input name="email" type="email" class="form-control" placeholder="Địa chỉ Email...">
            </div>
            <div class="form-group mg-form">
                <label class="cw" for="">Password</label>
                <input name="password" type="password" class="form-control" placeholder="Mật khấu...">
            </div>

            <button type="submit" class="btn btn-primary btn-block mg-form" style="width:100%; margin-top:16px;">Đăng nhập</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=forgot">Quên mật khẩu</a></p>
            <p class="text-center"><a href="?module=auth&action=register">Đăng kí tài khoản</a></p>
        </form>
    </div>
</div>

<?php
layouts('footer');
?>