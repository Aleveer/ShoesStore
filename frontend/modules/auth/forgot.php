<!-- Quên mật khẩu -->

<!-- Đăng nhập tài khoản -->

<?php
require_once __DIR__ . '/../../../backend/bus/user_bus.php';

if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Quên mật khẩu'
];

// Đã nhúng file function.php bên index.php
layouts('header', $data);

// Kiểm tra trạng thái đăng nhập
if (isLogin()) {
    redirect('?module=indexphp&action=userhomepage');
} else {
    if (isPost()) {
        $filterAll = filter();
        if (!empty($filterAll['email'])) {
            $email = $filterAll['email'];
            $userQuery = UserBUS::getInstance()->getModelByEmail($email);
            if (!empty($userQuery)) {
                // Tạo forgotToken
                $forgotToken = sha1(uniqid() . time());

                $userQuery->setForgotToken($forgotToken);
                $updateStatus = UserBUS::getInstance()->updateModel($userQuery);

                if ($updateStatus) {
                    // Tạo link khôi phục mật khẩu
                    $linkReset = _WEB_HOST . '?module=auth&action=reset&token=' . $forgotToken;

                    $subject = 'Yêu cầu khôi phục mật khẩu!';
                    $content = 'Chào bạn! <br/>';
                    $content .= 'Chúng tôi nhận được yêu cầu khôi phục mật khẩu từ bạn, vui lòng click vào link sau để đổi lại mật khẩu: <br/>';
                    $content .= $linkReset . '<br/>';
                    $content .= 'Trân trọng cảm ơn!!';

                    $sendMailStatus = sendMail($email, $subject, $content);
                    if ($sendMailStatus) {
                        setFlashData('msg', 'Vui lòng kiểm tra email để đặt lại mật khẩu!');
                        setFlashData('msg_type', 'success');
                    } else {
                        setFlashData('msg', 'Lỗi hệ thống, vui lòng thử lại sau!(email)');
                        setFlashData('msg_type', 'danger');
                    }
                } else {
                    setFlashData('msg', 'Lỗi hệ thống, vui lòng thử lại sau!');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Tài khoản không tồn tại!');
                setFlashData('msg_type', 'danger');
            }
        } else {
            // Email not provided, display error message
            setFlashData('msg', 'Vui lòng nhập địa chỉ email!');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=auth&action=forgot');
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');

?>

<div class="row">
    <div class="cw col-4" style="margin:50px auto;">
        <h2 style="text-align: center; text-transform: uppercase;">Quên mật khẩu</h2>
        <?php
        if (!empty($msg)) {
            getMsg($msg, $msgType);
        } ?>
        <form action="" method="post">
            <div class="form-group mg-form">
                <label for="">Email</label>
                <input name="email" type="email" class="form-control" placeholder="Địa chỉ Email...">
            </div>
            <button type="submit" class="btn btn-primary btn-block mg-form mt-3" style="width:100%;">Gửi</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=login">Đăng nhập</a></p>
            <p class="text-center"><a href="?module=auth&action=register">Đăng kí tài khoản</a></p>
        </form>
    </div>
</div>

<?php
layouts('footer');
?>