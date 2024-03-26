<!-- Đăng xuất -->

<?php

if (!defined('_CODE')) {
    die('Access denied');
}

// Xoá token trong tokenLogin trong DB, đồng thời xoá token trong session khi đăng nhập tạo ra
if (isLogin()) {
    $token = getSession('tokenLogin');
    delete('tokenLogin', "token = '$token'");
    removeSession('tokenLogin');
    redirect('?module=auth&action=login');
}