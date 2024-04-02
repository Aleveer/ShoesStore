<!-- Đăng xuất -->

<?php

if (!defined('_CODE')) {
    die('Access denied');
}
require_once(__DIR__ . "/../backend/bus/token_login_bus.php");

use services\session;

// Xoá token trong tokenLogin trong DB, đồng thời xoá token trong session khi đăng nhập tạo ra
if (isLogin()) {
    $token = session::getInstance()->getSession('tokenLogin');
    $tokenModel = TokenLoginBUS::getInstance()->getModelByToken($token);
    TokenLoginBUS::getInstance()->deleteModel($tokenModel);
    session::getInstance()->removeSession('tokenLogin');
    redirect('?module=auth&action=login');
}