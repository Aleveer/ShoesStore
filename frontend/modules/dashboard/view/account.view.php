<?php
use backend\bus\RoleBUS;
use backend\bus\UserBUS;
use backend\services\PasswordUtilities;

$title = 'Accounts';

if (!defined('_CODE')) {
    die('Access denied');
}

if (!isAllowToDashBoard()) {
    die('Access denied');
}
include (__DIR__ . '/../inc/head.php');
include (__DIR__ . '/../inc/app/app.php');
$userList = UserBUS::getInstance()->getAllModels();
?>

<body>
    <!-- HEADER -->
    <?php include (__DIR__ . '/../inc/header.php'); ?>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR MENU -->
            <?php include (__DIR__ . '/../inc/sidebar.php'); ?>

            <!-- MAIN -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <?= $title ?>
                    </h1>
                    <div class="search-group input-group">
                        <input type="text" id="accountSearch" class="searchInput form-control">
                        <button type="button" class="btn btn-sm btn-primary align-middle padx-0 pady-0">
                            <span data-feather="search"></span>
                        </button>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-success align-middle" data-bs-toggle="modal"
                            data-bs-target="#addModal" id="addAcount" class="addBtn">
                            <span data-feather="plus"></span>
                            Add
                        </button>
                    </div>
                </div>

                <!-- BODY DATABASE -->
                <table class="table align-middle table-borderless table-hover text-start">
                    <thead>
                        <tr class="align-middle">
                            <th></th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <?php foreach ($userList as $user): ?>
                        <tbody>
                            <tr>
                                <td class='col-1'><img src="<?php echo $user->getImage(); ?>"
                                        style="width: 50px; height: 50px;" alt="ATR">
                                </td>
                                </td>
                                <td class='col-1'><?= $user->getUsername() ?></td>
                                <td class='col-2'><?= $user->getName() ?></td>
                                <td class='col-2'><?= $user->getEmail() ?></td>
                                <td class='col-1'><?= $user->getPhone() ?></td>
                                <td class="col-2"><?= $user->getAddress() ?></td>
                                <td class='col-1'>
                                    <?= RoleBUS::getInstance()->getModelById($user->getRoleId())->getName(); ?>
                                </td>
                                <td class='col-1'><?= $user->getStatus() ?></td>
                                <td>
                                    <a href='http://localhost/frontend/index.php?module=dashboard&view=account.update&id=<?= $user->getId() ?>'
                                        class='btn btn-sm btn-primary'>
                                        <span data-feather='tool'></span>
                                    </a>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" id="lockAccountBtn">
                                        <span data-feather="lock"></span>
                                    </button>
                                    <button class="btn btn-sm btn-danger" id='unlockAccountBtn' name='unlockAccountBtn'>
                                        <span data-feather="unlock"></span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
            </div>
        </div>
    <?php endforeach; ?>
    </table>
    </main>

    <!-- Add modal -->
    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" style="width: 100%">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3">
                        <div class="col-md-4">
                            <label for="inputUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="inputUsername" name="inputUsernameName">
                        </div>
                        <div class="col-md-3">
                            <label for="inputPassword" class="form-label">Password</label>
                            <input type="password" name="" id="inputPassword" name="inputPasswordName"
                                class="form-control">
                        </div>
                        <div class="col-5">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="inputEmail" name="inputEmailName">
                        </div>
                        <div class="col-5">
                            <label for="inputName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="inputName" name="inputNameName">
                        </div>
                        <div class="col-3">
                            <label for="inputPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="inputPhone" name="inputPhoneName">
                        </div>
                        <div class="col-md-2">
                            <label for="inputGender" class="form-label">Gender</label>
                            <select id="inputGender" class="form-select">
                                <option value="1" selected>Male</option>
                                <option value="0">Female</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="inputRole" class="form-label">Role</label>
                            <select name="" id="inputRole" class="form-select">
                                <option value="1">Admin</option>
                                <option value="2">Manager</option>
                                <option value="3">Employee</option>
                                <option value="4">Customer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label">Address</label>
                            <input type="text" name="inputAddressName" id="inputAddress" class="form-control">
                        </div>
                        <div class="col-6  userImg">
                            <img id="imgPreview" src="..\..\..\..\templates\images\680098.jpg" alt="Preview Image" a
                                class="img-circle">
                        </div>
                        <div class="col-6">
                            <label for="inputImg">Image</label>
                            <input type="file" class="form-control" name="imgProduct" id="inputImg" accept="image/*">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php include (__DIR__ . '/../inc/app/app.php'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/dashboard/add_user.js"></script>
    <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/dashboard/update_user.js"></script>
    <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/dashboard/delete_user.js"></script>
</body>

</html>