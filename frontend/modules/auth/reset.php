<!-- reset password -->
<!-- TODO: FIX -->
<?php

use services\session;

require_once(__DIR__ . "/../../../backend/services/validation.php");
require_once(__DIR__ . "/../../../backend/bus/user_bus.php");
require_once(__DIR__ . "/../../../backend/models/user_model.php");
require_once(__DIR__ . "/../../../backend/enums/status_enums.php");
require_once(__DIR__ . "/../../../backend/enums/roles_enums.php");
require_once(__DIR__ . "/../../../backend/services/password-utilities.php");

if (!defined('_CODE')) {
    die('Access denied');
}
$data = [
    'pageTitle' => 'Reset Password'
];
layouts('header', $data);

if (!empty(filter()['token'])) $token = filter()['token'];



if (!empty($token)) {
    $userQuery = UserBUS::getInstance()->getModelByForgotToken($token);
    if (!empty($userQuery)) {
        if (isPost()) {
            $filterAll = filter();
            $errors = []; // Mảng chứa các lỗi

            $errors = UserBUS::getInstance()->validateResetPassword($filterAll['password'], $filterAll['password_confirm']);

            // Phải setFlashData vì nếu không set thì sau khi reload (redirect) sẽ mất
            // Đây là một trong những chức năng của session
            if (empty($errors)) {
                // Xử lí việc update mật khẩu
                $passwordHash = password_hash($filterAll['password'], PASSWORD_DEFAULT);

                $userQuery->setPassword($passwordHash);
                $userQuery->setForgotToken(null);
                $userQuery->setUpdateAt(date('Y-m-d H:i:s'));
                $updateStatus = UserBUS::getInstance()->updateModel($userQuery);
                if ($updateStatus) {
                    setFlashData('msg', 'Thay đổi mật khẩu thành công!!!');
                    setFlashData('msg_type', 'success');
                    redirect('?module=auth&action=login');
                } else {
                    setFlashData('msg', 'Lỗi hệ thống, vui lòng thử lại sau!');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu!');
                setFlashData('msg_type', 'danger');
                setFlashData('errors', $errors);
                redirect("?module=auth&action=reset&token=$token");
            }
        }
        $msg = getFlashData('msg');
        $msg_type = getFlashData('msg_type');
        $errors = getFlashData('errors');
?>
        <!-- Bảng đặt lại mật khẩu -->
        <div class="row">
            <div class="col-4" style="margin: 24px auto;">
                <form class="cw" action="" method="post">
                    <h2 style="text-align:center; text-transform: uppercase;">Đặt lại mật khấu</h2>
                    <?php if (!empty($msg)) {
                        getMsg($msg, $msg_type);
                    } ?>

                    <div class="form-group mg-form">
                        <label for="">Mật khẩu</label>
                        <input name="password" class="form-control" type="password" placeholder="Nhập mật khẩu...">
                        <?php echo formError('password', $errors) ?>
                    </div>

                    <div class="form-group mg-form mt-2">
                        <label for="">Nhập lại mật khẩu</label>
                        <input name="password_confirm" class="form-control" type="password" placeholder="Nhập lại mật khẩu...">
                        <?php echo formError('password_confirm', $errors) ?>
                    </div>

                    <input type="hidden" name="token" value="<?php echo $token ?>">
                    <button type="submit" class="btn btn-primary btn-block mg-form mt-3" style="width:100%;">Gửi</button>
                    <hr>
                    <p class="text-center"><a href="?module=auth&action=login">Đăng nhập</a></p>
                </form>
            </div>
        </div>

<?php
    } else {
        getMsg("Liên kết không tồn tại hoặc đã hết hạn.", "danger");
    }
} else {
    getMsg("Liên kết không tồn tại hoặc đã hết hạn.", "danger");
}
?>

<?php
layouts('footer', $data);

?>