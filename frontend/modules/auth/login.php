<!-- Đăng nhập tài khoản -->

<?php
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
    if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
        // Kiểm tra đăng nhập
        $email = $filterAll['email'];
        $password = $filterAll['password'];

        $userQuery = getRow("SELECT password, id FROM user WHERE email='$email'");
        if (!empty($userQuery)) {
            $passwordHash = $userQuery['password'];

            if (password_verify($password, $passwordHash)) {
                // Tạo tokenLogin
                $tokenLogin = sha1(uniqid() . time());

                // Insert vào bảng loginToken
                $dataInsert = [
                    "user_id" => $userQuery['id'],
                    "token" => $tokenLogin,
                    "create_at" => date("Y-m-d H:i:s")
                ];

                $insertStatus = insert('tokenLogin', $dataInsert);

                if ($insertStatus) {
                    // Insert thành công
                    // Lưu login token vào session
                    setSession('tokenLogin', $tokenLogin);
                    redirect('?module=indexphp&action=userhomepage');
                } else {
                    setFlashData('msg', 'Không thể đăng nhập, vui lòng thử lại sau!');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Mật khẩu không chính xác!');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Email không tồn tại!');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng nhập email và password!');
        setFlashData('msg_type', 'danger');
    }
    redirect('?module=auth&action=login');
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');

?>


<div class="row">
    <div class="col-4" style="margin:50px auto;">
        <h2  class="cw" style="text-align: center; text-transform: uppercase;">Đăng Nhập</h2>
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