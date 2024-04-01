<?php
session_start();

// require config
require __DIR__ . '/config.php';

require_once __DIR__ . '/includes/phpmailer/Exception.php';
require_once __DIR__ . '/includes/phpmailer/PHPMailer.php';
require_once __DIR__ . '/includes/phpmailer/SMTP.php';

// require includes
require __DIR__ . '/includes/function.php';
require __DIR__ . '/includes/connect.php';
require __DIR__ . '/includes/database.php';
require __DIR__ . '/includes/session.php';
require __DIR__ . '/../backend/services/session.php';

$module = _MODULE;
$action = _ACTION;

if (!empty($_GET['module'])) {
    if (is_string($_GET['module'])) {
        $module = trim($_GET['module']);
    }
}

if (!empty($_GET['action'])) {
    if (is_string($_GET['action'])) {
        $action = trim($_GET['action']);
    }
}

$path = 'modules\\' . $module . '\\' . $action . '.php';

if (file_exists($path)) require_once($path);
else {
    require_once('modules\error\404.php');
}
