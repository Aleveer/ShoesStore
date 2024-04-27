<?php

use backend\bus\UserBUS;
use backend\bus\UserPermissionBUS;
use backend\bus\PermissionBUS;
use backend\bus\RoleBUS;
use backend\bus\RolePermissionBUS;
use backend\bus\TokenLoginBUS;
use backend\services\PasswordUtilities;
use backend\services\session;
use backend\models\TokenLoginModel;
use backend\enums\StatusEnums;

if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Đăng nhập'
];

// if (isLogin()) {
//     redirect('?module=indexphp&action=userhomepage');
// }

if (isPost()) {
    $filterAll = filter();
    if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
        $email = $filterAll['email'];
        $password = $filterAll['password'];
        $userQuery = UserBUS::getInstance()->getModelByEmail($email);
        if (!empty($userQuery)) {
            $passwordHash = $userQuery->getPassword();
            // Kiểm tra password verify
            if (PasswordUtilities::getInstance()->verifyPassword($password, $passwordHash)) {
                // Tạo tokenLogin
                $tokenLogin = sha1(uniqid() . time());

                $loginTkn = new TokenLoginModel(0, $userQuery->getId(), $tokenLogin, date("Y-m-d H:i:s"));
                $insertTokenLoginStatus = TokenLoginBUS::getInstance()->addModel($loginTkn);

                if ($insertTokenLoginStatus) {
                    $status = $userQuery->getStatus();
                    if ($status === StatusEnums::INACTIVE || $status === StatusEnums::ACTIVE) {
                        $userQuery->setStatus(StatusEnums::ACTIVE);
                        UserBUS::getInstance()->updateModel($userQuery);
                        UserBUS::getInstance()->refreshData();
                    }
                    session::getInstance()->setSession('tokenLogin', $tokenLogin);
                    // Trả về dữ liệu JSON
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'success', 'message' => 'Login successful']);
                    exit;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'error', 'message' => 'Cannot login! Please try again!']);
                    exit;
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Wrong password, Please try again!']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Email does not exist!']);
            exit;
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields!']);
        exit;
    }
}

?>

<div id="header">
    <?php layouts('header', $data); ?>
</div>

<body>
    <div class="row">
        <div class="col-4" style="margin:50px auto;">
            <h2 class="cw" style="text-align: center; text-transform: uppercase;">Login</h2>
            <div class="message"></div>
            <form action="" method="post">
                <div class="form-group mg-form">
                    <label class="cw" for="">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="Your email address...">
                </div>
                <div class="form-group mg-form">
                    <label class="cw" for="">Password</label>
                    <input name="password" type="password" class="form-control" placeholder="Your password...">
                </div>

                <button id="loginBtn" type="button" class="btn btn-primary btn-block mg-form" style="width:100%; margin-top:16px;">Login</button>
                <hr>
                <p class="text-center"><a href="?module=auth&action=forgot">Forgot password?</a></p>
                <p class="text-center"><a href="?module=auth&action=register">Register</a></p>
            </form>
        </div>
    </div>
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var loginBtn = $("#loginBtn");

        if (loginBtn.length) {
            loginBtn.on("click", function(e) {
                var email = $('input[name="email"]').val();
                var password = $('input[name="password"]').val();
                if ($('.messageErrorDetail').length) {
                    $('.messageErrorDetail').text();
                }
                $.ajax({
                    url: "http://localhost/ShoesStore/frontend/?module=auth&action=login",
                    type: "POST",
                    dataType: "json",
                    data: {
                        email: email,
                        password: password
                    },

                    success: function(data) {
                        // Xử lý phản hồi từ server ở đây
                        console.log(data); // Hiển thị dữ liệu phản hồi từ server
                        if (data.status == 'error') {
                            if ($('.messageErrorDetail').length) {
                                $('.messageErrorDetail').text(data.message);
                            } else {
                                $('.message').append("<div class='messageErrorDetail cw text-center alert alert-danger'>" + data.message + "</div>");
                            }
                        } else {
                            window.location.href = "?module=indexphp&action=userhomepage";
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        alert("Error occurred. Please try again.");
                    },
                });
            });
        }
    });
</script>