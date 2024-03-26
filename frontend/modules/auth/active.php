<!-- Kích hoạt tài khoản -->
<?php

use services\session;

if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'active' => 'Active'
];

layouts('header-login', $data);

// Check if user is logged in
if (isLogin()) {
    $userId = $_SESSION['userId'];

    // Update user status in the database
    $data = [
        'status' => 1,
    ];

    $updateStatus = UserBUS::getInstance()->updateModelStatus($userId, $data);
    $session = new session();
    if ($updateStatus) {
        $session->setFlash('msg', 'Kích hoạt tài khoản thành công!');
        $session->setFlash('msg_type', 'success');
        redirect('?module=auth&action=login');
    } else {
        $session->setFlash('msg', 'Kích hoạt tài khoản thất bại, vui lòng liên hệ quản trị viên!');
        $session->setFlash('msg_type', 'danger');
    }
} else {
    getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
}

layouts('footer-login');
