<?php
use backend\bus\CategoriesBUS;
use backend\bus\ProductBUS;
use backend\bus\RoleBUS;
use backend\bus\UserBUS;
use backend\enums\StatusEnums;
use backend\services\PasswordUtilities;

$title = 'Edit Account Information';
if (!defined('_CODE')) {
    die('Access denied');
}

if (!isAllowToDashBoard()) {
    die('Access denied');
}
include (__DIR__ . '/../inc/head.php');

global $id;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = UserBUS::getInstance()->getModelById($id);
    if ($user === null) {
        die('User does not exist');
    }
} else {
    die('User id is missing');
}
?>

<div id="header">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</div>

<body>
    <?php include (__DIR__ . '/../inc/header.php'); ?>
    <div class="row g-3">
        <!-- User Information -->
        <div class="col-md-12">
            <div class="row">
                <!-- Username -->
                <div class="col-md-3">
                    <label for="inputAccountUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="inputEditAccountUsername" value="<?php $username = UserBUS::getInstance()->getModelById($id)->getUsername();
                    echo $username; ?>">
                </div>
                <!-- Password -->
                <div class="col-md-3">
                    <label for="inputAccountPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputEditAccountPassword" value="<?php $password = UserBUS::getInstance()->getModelById($id)->getPassword();
                    echo $password; ?>">
                </div>
                <!-- Name -->
                <div class="col-md-3">
                    <label for="inputAccountName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="inputEditAccountName" value="<?php $name = UserBUS::getInstance()->getModelById($id)->getName();
                    echo $name; ?>">
                </div>
                <!-- Email -->
                <div class="col-md-3">
                    <label for="inputAccountEmail" class="form-label">Email</label>
                    <input type="text" class="form-control" id="inputEditAccountEmail" value="<?php $email = UserBUS::getInstance()->getModelById($id)->getEmail();
                    echo $email; ?>">
                </div>
            </div>
        </div>

        <!-- More User Information -->
        <div class="col-md-12">
            <div class="row">
                <!-- Phone -->
                <div class="col-md-3">
                    <label for="inputAccountPhone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="inputEditAccountPhone" value="<?php $phone = UserBUS::getInstance()->getModelById($id)->getPhone();
                    echo $phone; ?>">
                </div>
                <!-- Gender -->
                <div class="col-md-3">
                    <label for="inputGender" class="form-label">Gender</label>
                    <select id="inputEditGender" class="form-select">
                        <?php $gender = UserBUS::getInstance()->getModelById($id)->getGender(); ?>
                        <option value="0" <?php echo $gender == 0 ? 'selected' : ''; ?>>Male</option>
                        <option value="1" <?php echo $gender == 1 ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
                <!-- Status -->
                <div class="col-md-3">
                    <label for="inputStatus" class="form-label">Status</label>
                    <select id="inputEditStatus" class="form-select">
                        <?php $status = UserBUS::getInstance()->getModelById($id)->getStatus(); ?>
                        <option value="active" <?php echo $status == StatusEnums::ACTIVE ? 'selected' : ''; ?>>Active
                        </option>
                        <option value="inactive" <?php echo $status == StatusEnums::INACTIVE ? 'selected' : ''; ?>>
                            Inactive</option>
                        <option value="banned" <?php echo $status == StatusEnums::BANNED ? 'selected' : ''; ?>>Banned
                        </option>
                    </select>
                </div>
                <!-- Address -->
                <div class="col-md-3">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" id="inputEditAddress" value="<?php $address = UserBUS::getInstance()->getModelById($id)->getAddress();
                    echo $address; ?>">
                </div>
            </div>
        </div>

        <!-- Role and Image -->
        <div class="col-md-12">
            <div class="row">
                <!-- Role -->
                <div class="col-md-4">
                    <label for="inputAccountRole" class="form-label">Role</label>
                    <select id="inputEditAccountRole" class="form-select">
                        <?php
                        $roles = RoleBUS::getInstance()->getAllModels();
                        foreach ($roles as $role) {
                            $selected = ($role->getId() == UserBUS::getInstance()->getModelById($id)->getRoleId()) ? 'selected' : '';
                            echo '<option value="' . $role->getId() . '" ' . $selected . ' data-value="' . $role->getId() . '">' . $role->getName() . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- Image -->
                <div class="col-md-3">
                    <label for="inputImg">Image (.JPG, .JPEG, .PNG)</label>
                    <input type="file" class="form-control" name="imgProduct" id="inputEditImg"
                        accept=".jpg, .jpeg, .png">
                </div>
                <!-- Image Preview -->
                <div class="col-md-4">
                    <img src="<?php echo UserBUS::getInstance()->getModelById($id)->getImage(); ?>" alt="Image"
                        id="imageEdit" style="width: 100px; height: 100px;">
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="col-md-12">
            <form method="POST">
                <div class="text-center">
                    <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateEditBtn"
                        name="updateEdtBtnName">Update</button>
                </div>
            </form>
        </div>
        <?php
        if (isPost()) {
            if (isset($_POST['updateEditBtnName'])) {
                $accountUpdate = UserBUS::getInstance()->getModelById($id);
                $username = $_POST['usernameEdit'] ?? '';

                //Handle Password:
                $newPassword = $_POST['passwordEdit'] ?? '';

                if (trim($newPassword) == '') {
                    $newPassword = $accountUpdate->getPassword();
                }

                $currentPassword = $accountUpdate->getPassword();
                $newPasswordHash = null;
                if ($newPassword != $currentPassword) {
                    $newPasswordHash = PasswordUtilities::getInstance()->hashPassword($newPassword);
                }

                $name = $_POST['nameEdit'] ?? '';
                $email = $_POST['emailEdit'] ?? '';
                if (UserBUS::getInstance()->isEmailTaken($email)) {
                    echo "<script>alert('Email is already taken!')</script>";
                    error_log("Email is already taken!");
                    return;
                }

                $phone = $_POST['phoneEdit'] ?? '';
                if (UserBUS::getInstance()->isPhoneTaken($phone)) {
                    echo "<script>alert('Phone number is already taken!')</script>";
                    error_log("Phone number is already taken!");
                    return;
                }

                $gender = $_POST['genderEdit'] ?? '';
                $status = $_POST['statusEdit'] ?? '';
                $address = $_POST['addressEdit'] ?? '';
                $role = $_POST['roleEdit'] ?? '';

                $accountUpdate->setUsername($username);
                if ($newPasswordHash != null) {
                    $accountUpdate->setPassword($newPasswordHash);
                } else {
                    $accountUpdate->setPassword($currentPassword);
                }
                $accountUpdate->setName($name);
                $accountUpdate->setEmail($email);
                $accountUpdate->setPhone($phone);
                $accountUpdate->setGender($gender);
                $accountUpdate->setStatus($status);
                $accountUpdate->setAddress($address);
                $accountUpdate->setRoleId($role);

                $imageData = $_POST['imageEdit'];
                $accountUpdate->setImage($imageData);
                UserBUS::getInstance()->updateModel($accountUpdate);
                UserBUS::getInstance()->refreshData();
            }
        }
        ?>
        <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/dashboard/update_account.js"></script>
    </div>

</body>