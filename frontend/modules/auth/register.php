<!-- Đăng kí tài khoản -->
<!--TODO: Need some in-depth testing -->
<?php

use services\session;

require_once 'backend/services/validation.php';
require_once 'backend/services/session.php';
require_once 'backend/bus/user_bus.php';
require_once 'backend/models/user_model.php';
require_once 'backend/enums/status_enums.php';
require_once 'backend/enums/roles_enums.php';
require_once 'backend/utils/password_utilities.php';

if (!defined('_CODE')) {
    die('Access denied');
}

if (isPost()) {
    //$id, $username, $password, $email, $name, $phone, $gender, $image, $roleId, $status, $address
    $userModel = new UserModel(
        null,
        $filterAll['username'],
        $filterAll['password'],
        $filterAll['email'],
        $filterAll['fullname'],
        $filterAll['phone'],
        $filterAll['gender'],
        null,
        0,
        StatusEnums::ACTIVE,
        $filterAll['address']
    );

    $count = UserBUS::getInstance()->validateModel($userModel);

    // Phải $session->setFlash vì nếu không set thì sau khi reload (redirect) sẽ mất
    // Đây là một trong những chức năng của session
    if ($count == 0) {
        $activeToken = sha1(uniqid() . time());
        $dataInsert = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'address' => $filterAll['address']
        ];
        $insertStatus = UserBUS::getInstance()->addModel($dataInsert);
        //     if ($insertStatus) {
        //         // Tạo link kích hoạt
        //         $linkActive = _WEB_HOST . '?module=auth&action=active&token=' . $activeToken;
        //         // Thiết lập gửi mail
        //         $subject = $filterAll['fullname'] . ' vui lòng kích hoạt tài khoản!!!';
        //         $content = 'Chào ' . $filterAll['fullname'] . '<br/>';
        //         $content .= 'Vui lòng click vào đường link dưới đây để kích hoạt tài khoản:' . '<br/>';
        //         $content .= $linkActive . '<br/>';
        //         $content .= 'Trân trọng cảm ơn!!';


        //         // Tiến hành gửi mail
        //         $session = new session();
        //         $sendMailStatus = sendMail($filterAll['email'], $subject, $content);
        //         if ($sendMailStatus) {
        //             $session->setFlash('msg', 'Đăng kí thành công, vui lòng kiểm tra email để kích hoạt tài khoản!');
        //             $session->setFlash('msg_type', 'success');
        //         } else {
        //             $session->setFlash('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau');
        //             $session->setFlash('msg_type', 'danger');
        //         }
        //     }
        //     redirect('?module=auth&action=register');
        // } else {
        //     $session->setFlash('msg', 'Vui lòng kiểm tra lại dữ liệu!');
        //     $session->setFlash('msg_type', 'danger');
        //     $session->setFlash('errors', $errors);
        //     $session->setFlash('duLieuDaNhap', $filterAll);
        //     redirect('?module=auth&action=register');
        // }

        if ($insertStatus) {
            // Store user ID in session
            $_SESSION['registerUserId'] = $insertStatus;

            // Redirect to activation page
            redirect('?module=auth&action=active');
        } else {
            // Registration failed, display error message
            $session->setFlash('msg', 'Registration failed!');
            $session->setFlash('msg_type', 'danger');
            redirect('?module=auth&action=register');
        }
    } else {
        // Validation failed, display error message
        $session->setFlash('msg', 'Validation failed!');
        $session->setFlash('msg_type', 'danger');
        redirect('?module=auth&action=register');
    }
}

$msg = $session->getFlash('msg');
$msg_type = $session->getFlash('msg_type');
$errors = $session->getFlash('errors');
$duLieuDaNhap = $session->getFlash('duLieuDaNhap');


$data = [
    'pageTitle' => 'Đăng ký'
];
layouts('header', $data);
?>

<div class="row">
    <div class="col-4" style="margin: 24px auto;">
        <form class="cw" action="" method="post">
            <h2 style="text-align:center; text-transform: uppercase;">Đăng ký</h2>
            <?php if (!empty($msg)) {
                getMsg($msg, $msg_type);
            } ?>
            <div class="form-group mg-form">
                <label for="">Họ tên</label>
                <input name="fullname" class="form-control" type="text" placeholder="Họ tên..." value="<?php echo formOldInfor('fullname', $duLieuDaNhap) ?>">
                <?php echo formError('fullname', $errors) ?>
            </div>

            <div class="form-group mg-form">
                <label for="">Email</label>
                <input name="email" class="form-control" type="text" placeholder="Email..." value="<?php echo formOldInfor('email', $duLieuDaNhap) ?>">
                <?php echo formError('email', $errors) ?>
            </div>

            <div class="form-group mg-form">
                <label for="">Số điện thoại</label>
                <input name="phone" class="form-control" type="number" placeholder="Số điện thoại..." value="<?php echo formOldInfor('phone', $duLieuDaNhap) ?>">
                <?php echo formError('phone', $errors) ?>
            </div>

            <div class="form-group mg-form">
                <label for="">Địa chỉ</label>
                <input name="address" class="form-control" type="text" placeholder="Nhập địa chỉ..." value="<?php echo formOldInfor('address', $duLieuDaNhap) ?>">
                <?php echo formError('address', $errors) ?>
            </div>

            <div class="form-group mg-form">
                <label for="">Mật khẩu</label>
                <input name="password" class="form-control" type="password" placeholder="Nhập mật khẩu..." value="<?php echo formOldInfor('password', $duLieuDaNhap) ?>">
                <?php echo formError('password', $errors) ?>
            </div>

            <div class="form-group mg-form">
                <label for="">Nhập lại mật khẩu</label>
                <input name="password_confirm" class="form-control" type="password" placeholder="Nhập lại mật khẩu..." value="<?php echo formOldInfor('password_confirm', $duLieuDaNhap) ?>">
                <?php echo formError('password_confirm', $errors) ?>
            </div>

            <!-- Add more fields here -->

            <button type="submit" class="btn btn-primary btn-block mg-form" style="width:100%; margin-top:16px;">Đăng ký</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=login">Đăng nhập</a></p>
        </form>
    </div>
</div>


<?php
layouts('footer');
?>