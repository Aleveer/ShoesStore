<?php
use backend\bus\RoleBUS;
use backend\bus\RolePermissionBUS;
use backend\bus\TokenLoginBUS;
use backend\bus\UserBUS;
use backend\services\session;

function isActivePage($currentPage, $pageName)
{
    if ($currentPage === $pageName) {
        return 'active';
    }
    return '';
}

$token = session::getInstance()->getSession('tokenLogin');
$tokenModel = TokenLoginBUS::getInstance()->getModelByToken($token);
$userModel = UserBUS::getInstance()->getModelById($tokenModel->getUserId());
$rolesPermission = RolePermissionBUS::getInstance()->getModelByRoleId($userModel->getRoleId());

function checkPermission($rolesPermission, $permissionId)
{
    foreach ($rolesPermission as $rolePermission) {
        if ($rolePermission->getPermissionId() == $permissionId) {
            return true;
        }
    }
    return false;
}
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <?php
                if (checkPermission($rolesPermission, 5)) {
                    ?>
                    <a class="nav-link <?php echo isActivePage($_GET['view'], 'dashboard.view'); ?>" aria-current="page"
                        href="?module=dashboard&view=dashboard.view">
                        <span data-feather="home"></span>
                        Dashboard
                    </a>
                    <?php
                }
                ?>
            </li>
            <li class="nav-item">
                <?php
                if (checkPermission($rolesPermission, 3)) {
                    ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActivePage($_GET['view'], 'order.view'); ?>"
                        href="?module=dashboard&view=order.view">
                        <span data-feather="file"></span>
                        Orders
                    </a>
                </li>
                <?php
                }
                ?>
            </li>
            <li class="nav-item">
                <?php
                if (checkPermission($rolesPermission, 1)) {
                    ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActivePage($_GET['view'], 'product.view'); ?>"
                        href="?module=dashboard&view=product.view">
                        <span data-feather="shopping-cart"></span>
                        Products
                    </a>
                </li>
                <?php
                }
                ?>
            </li>
            <li class="nav-item">
                <?php
                if (checkPermission($rolesPermission, 2)) {
                    ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActivePage($_GET['view'], 'category.view'); ?>"
                        href="?module=dashboard&view=category.view">
                        <span data-feather="list"></span>
                        Categories
                    </a>
                </li>
                <?php
                }
                ?>
            </li>
            <li class="nav-item">
                <?php
                if (checkPermission($rolesPermission, 2)) {
                    ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActivePage($_GET['view'], 'size.view'); ?>"
                        href="?module=dashboard&view=size.view">
                        <span data-feather="list"></span>
                        Sizes
                    </a>
                </li>
                <?php
                }
                ?>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo isActivePage($_GET['view'], 'coupon.view'); ?>"
                    href="?module=dashboard&view=coupon.view">
                    <span data-feather="star"></span>
                    Coupons
                </a>
            </li>
            <li class="nav-item">
                <?php
                if (checkPermission($rolesPermission, 2)) {
                    ?>
                    <a class="nav-link <?php echo isActivePage($_GET['view'], 'inventory.view'); ?>"
                        href="?module=dashboard&view=inventory.view">
                        <span data-feather="package"></span>
                        Inventory
                    </a>
                    <?php
                }
                ?>
            </li>
            <li class="nav-item">
                <?php
                if (checkPermission($rolesPermission, 4)) {
                    ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActivePage($_GET['view'], 'account.view'); ?>"
                        href="?module=dashboard&view=account.view">
                        <span data-feather="users"></span>
                        Accounts
                    </a>
                </li>
                <?php
                }
                ?>
            <li class="nav-item">
                <?php
                if (checkPermission($rolesPermission, 6)) {
                    ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActivePage($_GET['view'], 'permission.view'); ?>"
                        href="?module=dashboard&view=permission.view">
                        <span data-feather="life-buoy"></span>
                        Permissions
                    </a>
                </li>
                <?php
                }
                ?>
            <li class="nav-item">
                <?php
                if (checkPermission($rolesPermission, 6)) {
                    ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActivePage($_GET['view'], 'role.view'); ?>"
                        href="?module=dashboard&view=role.view">
                        <span data-feather="tool"></span>
                        Roles Setup
                    </a>
                </li>
                <?php
                }
                ?>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="bar-chart-2"></span>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="layers"></span>
                    Integrations
                </a> -->
            </li>
        </ul>
    </div>
</nav>