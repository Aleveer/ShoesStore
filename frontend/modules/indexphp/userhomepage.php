<?php
if (!defined('_CODE')) {
    die('Access denied');
}

$data = [
    'pageTitle' => 'Trang chủ'
];

// Đã nhúng file function.php bên index.php
// require_once _WEB_PATH_TEMPLATE . '/layouts/' . 'header' . '.php';
// require_once _WEB_PATH_TEMPLATE . '/layouts/' . 'footer' . '.php';



// Kiểm tra trạng thái đăng nhập

// if (!isLogin()) {
//     redirect('?module=indexphp&action=userhomepage');
// }

?>
<!-- Header -->
<div id="header">
    <?php layouts("header") ?>
</div>
    <!-- Slider -->
<div id="slider">
    <?php require("navigatorslider.php") ?>
</div>


<!-- Content -->
<div id="content">
    <?php require("navigatorcontent.php") ?>


</div>


<!--Footer-->
<div id="footer">
<?php layouts('footer') ?>

</div>


