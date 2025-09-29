<?php
if (!defined('_CODE')) {
    die('Access denied');
}

// Render the chat interface
$data = [
    'pageTitle' => 'Chat Support'
];

// Layout
require_once _WEB_PATH_TEMPLATE . '/layouts/header.php';
// Chat Template
require_once _WEB_PATH_TEMPLATE . '/chat/chat.php';
// Footer
require_once _WEB_PATH_TEMPLATE . '/layouts/footer.php';