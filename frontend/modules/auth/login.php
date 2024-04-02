<?php

use services\session;

require_once __DIR__ . '/../../../backend/bus/user_bus.php';
require_once __DIR__ . '/../../../backend/bus/user_permission_bus.php';
require_once __DIR__ . '/../../../backend/bus/permission_bus.php';
require_once __DIR__ . '/../../../backend/bus/role_bus.php';
require_once __DIR__ . '/../../../backend/bus/role_permissions_bus.php';
require_once __DIR__ . '/../../../backend/bus/token_login_bus.php';
require_once __DIR__ . '/../../../backend/services/password-utilities.php';

if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Đăng nhập'
];

layouts('header', $data);

if (isLogin()) {
    redirect('?module=indexphp&action=userhomepage');
}

if (isPost()) {
    $filterAll = filter();
    $response = ['success' => false, 'msg' => ''];

    if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
        $email = $filterAll['email'];
        $password = $filterAll['password'];
        //TODO: Double check the code if it's actually logged in successfully, after logging in successfully, redirect to the user's homepage:
        //TODO: Fix weird bug that will never direct.


        
        $userQuery = UserBUS::getInstance()->getModelByEmail($email);
        if (!empty($userQuery)) {
            $passwordHash = $userQuery->getPassword();
            // Kiểm tra password verify
            if (PasswordUtilities::getInstance()->verifyPassword($password, $passwordHash)) {
                // Tạo tokenLogin
                $tokenLogin = sha1(uniqid() . time());

                $loginTkn = new TokenLoginModel($userQuery->getId(), $tokenLogin, date("Y-m-d H:i:s"));
                $insertTokenLoginStatus = TokenLoginBUS::getInstance()->addModel($loginTkn);


                if ($insertTokenLoginStatus) {
                    session::getInstance()->setSession('tokenLogin', $tokenLogin);
                    redirect('?module=indexphp&action=userhomepage');
                } else {
                    session::getInstance()->setFlashData('msg', 'Không thể đăng nhập, vui lòng thử lại sau!');
                    session::getInstance()->setFlashData('msg_type', 'danger');
                }
            } else {
                session::getInstance()->setFlashData('msg', 'Mật khẩu không chính xác!');
                session::getInstance()->setFlashData('msg_type', 'danger');
            }
        } else {
            session::getInstance()->setFlashData('msg', 'Email không tồn tại!');
            session::getInstance()->setFlashData('msg_type', 'danger');
        }
    } else {
        session::getInstance()->setFlashData('msg', 'Vui lòng nhập email và password!');
        session::getInstance()->setFlashData('msg_type', 'danger');
    }
    // redirect('?module=auth&action=login');
}
//header('Content-Type: application/json');
//echo json_encode($response);

$msg = session::getInstance()->getFlashData('msg');
$msgType = session::getInstance()->getFlashData('msg_type');
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
                <input name="password" type="password" class="form-control" placeholder="Mật khẩu...">
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