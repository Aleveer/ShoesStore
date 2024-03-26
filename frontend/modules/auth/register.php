<!-- Đăng kí tài khoản -->

<?php

if (!defined('_CODE')) {
    die('Access denied');
}

if (isPost()) {
    $filterAll = filter();
    $errors = []; // Mảng chứa các lỗi

    // Validate fullname: required, min-length = 6
    if (empty($filterAll['fullname'])) {
        $errors['fullname']['required'] = "Phải nhập họ tên!";
    } else {
        if (strlen($filterAll['fullname']) < 6) {
            $errors['fullname']['length'] = 'Phải nhập ít nhất 6 kí tự';
        }
    }

    // Validate email: required, đúng format, check tồn tại trong CSDL
    if (empty($filterAll['email'])) {
        $errors['email']['required'] = "Phải nhập Email!";
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT id FROM user WHERE email='$email'";
        $result = getQuantityRows($sql);
        if ($result > 0) $errors['email']['existed'] = 'Đã tồn tại Email!';
    }

    // Validate phone: required, đúng format, check tồn tại trong CSDL
    if (empty($filterAll['phone'])) {
        $errors['phone']['required'] = "Phải nhập số điện thoại!";
    } else {
        if (!isPhone($filterAll['phone'])) {
            $errors['phone']['format'] = 'Sai định dạng số điện thoại! (VD: 0913885625)';
        } else {
            $phone = $filterAll['phone'];
            $sql = "SELECT id FROM user WHERE phone='$phone'";
            $result = getQuantityRows($sql);
            if ($result > 0) $errors['phone']['existed'] = 'Đã tồn tại số điện thoại!';
        }
    }


    // Validate password: required, min-length = 8
    if (empty($filterAll['password'])) {
        $errors['password']['required'] = "Phải nhập mật khẩu!";
    } else {
        if (strlen($filterAll['password']) < 8) {
            $errors['password']['length'] = "Mật khẩu phải có tối thiểu 8 kí tự";
        }
    }

    // Validate confirm password: required, giống password
    if (empty($filterAll['password_confirm'])) {
        $errors['password_confirm']['required'] = "Phải nhập lại mật khẩu!";
    } else {
        if (!($filterAll['password_confirm'] == $filterAll['password'])) {
            $errors['password_confirm']['match'] = "Mật khẩu nhập lại không đúng!";
        }
    }


    // Phải setFlashData vì nếu không set thì sau khi reload (redirect) sẽ mất
    // Đây là một trong những chức năng của session
    if (empty($errors)) {

        $activeToken = sha1(uniqid() . time());
        $dataInsert = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'create_at' => date('Y-m-d H:i:s'),
            'address' => $filterAll['address']
        ];
        $insertStatus = insert('user', $dataInsert);
        if ($insertStatus) {
            // Tạo link kích hoạt
            $linkActive = _WEB_HOST. '?module=auth&action=active&token='.$activeToken;
            // Thiết lập gửi mail
            $subject = $filterAll['fullname']. ' vui lòng kích hoạt tài khoản!!!';
            $content = 'Chào '. $filterAll['fullname']. '<br/>';
            $content .= 'Vui lòng click vào đường link dưới đây để kích hoạt tài khoản:'.'<br/>';
            $content .= $linkActive . '<br/>';
            $content .= 'Trân trọng cảm ơn!!';


            // Tiến hành gửi mail
            $sendMailStatus = sendMail($filterAll['email'], $subject, $content);
            if ($sendMailStatus) {
                setFlashData('msg', 'Đăng kí thành công, vui lòng kiểm tra email để kích hoạt tài khoản!');
                setFlashData('msg_type', 'success');
            } else {
                setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau');
                setFlashData('msg_type', 'danger');
            }
        }
        redirect('?module=auth&action=register');
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu!');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('duLieuDaNhap', $filterAll);
        redirect('?module=auth&action=register');
    }
}

$msg = getFlashData('msg'); 
$msg_type = getFlashData('msg_type');
$errors = getFlashData('errors');
$duLieuDaNhap = getFlashData('duLieuDaNhap');


$data = [
    'pageTitle' => 'Đăng ký'
];
layouts('header', $data);
?>

<div class="row">
    <div class="col-4" style="margin: 24px auto;">
        <form class="cw" action="" method="post">
            <h2 style="text-align:center; text-transform: uppercase;">Đăng ký</h2>
            <?php if(!empty($msg)) {
                getMsg($msg, $msg_type);
            } ?>
            <div class="form-group mg-form">
                <label for="">Họ tên</label>
                <input 
                    name="fullname" 
                    class="form-control" 
                    type="text" 
                    placeholder="Họ tên..." 
                    value="<?php echo formOldInfor('fullname', $duLieuDaNhap) ?>"
                >
                <?php echo formError('fullname', $errors) ?>
            </div>

            <div class="form-group mg-form">
                <label for="">Email</label>
                <input 
                    name="email" 
                    class="form-control" 
                    type="text" 
                    placeholder="Email..."
                    value="<?php echo formOldInfor('email', $duLieuDaNhap) ?>"
                >
                <?php echo formError('email', $errors) ?>
            </div>

            <div class="form-group mg-form">
                <label for="">Số điện thoại</label>
                <input 
                    name="phone" 
                    class="form-control" 
                    type="number" placeholder="Số điện thoại..."
                    value="<?php echo formOldInfor('phone', $duLieuDaNhap) ?>"
                >
                <?php echo formError('phone', $errors) ?>
            </div>

            <div class="form-group mg-form">
                <label for="">Địa chỉ</label>
                <input 
                    name="address" 
                    class="form-control" 
                    type="text" 
                    placeholder="Nhập địa chỉ..."
                    value="<?php echo formOldInfor('address', $duLieuDaNhap) ?>"
                >
                <?php echo formError('password', $errors) ?>
            </div>

            <div class="form-group mg-form">
                <label for="">Mật khẩu</label>
                <input 
                    name="password" 
                    class="form-control" 
                    type="password" 
                    placeholder="Nhập mật khẩu..."
                    value="<?php echo formOldInfor('password', $duLieuDaNhap) ?>"
                >
                <?php echo formError('password', $errors) ?>
            </div>

            <div class="form-group mg-form">
                <label for="">Nhập lại mật khẩu</label>
                <input 
                    name="password_confirm" 
                    class="form-control" 
                    type="password" 
                    placeholder="Nhập lại mật khẩu..."
                    value="<?php echo formOldInfor('password_confirm', $duLieuDaNhap) ?>"
                >
                <?php echo formError('password_confirm', $errors) ?>
            </div>

            <button type="submit" class="btn btn-primary btn-block mg-form" style="width:100%; margin-top:16px;">Đăng ký</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=login">Đăng nhập</a></p>
        </form>
    </div>
</div>


<?php
layouts('footer');
?>