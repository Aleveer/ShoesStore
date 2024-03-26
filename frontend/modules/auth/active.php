<!-- Kích hoạt tài khoản -->
<?php

if (!defined('_CODE')) {
    die('Access denied');
}
$data = [
    'active' => 'Active'
];
layouts('header-login', $data);

if (!empty(filter()['token']))  $token = filter()['token'];
if (!empty($token)) {
    // nếu có tồn tại token thì truy vấn và CSDL để check xem có trùng activeToken trong user hay không
    $tokenQuery = getRow("SELECT id FROM user WHERE activeToken = '$token'");
    if (!empty($tokenQuery)) {
        $data = [
            'status' => 1,
            'activeToken' => null
        ];

        $updateStatus = update('user', $data, "id = '$tokenQuery[id]'");

        if ($updateStatus) {
            setFlashData('msg', 'Kích hoạt tài khoản thành công!');
            setFlashData('msg_type', 'success');
            redirect('?module=auth&action=login');
        } else {
            setFlashData('msg', 'Kích hoạt tài khoản thất bại, vui lòng liên hệ quản trị viên!');
            setFlashData('msg_type', 'danger');
        }
    } else {
        getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
    }
} else {
    getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
}
?>

<?php
layouts('footer-login');
?>