<?php
use backend\bus\RoleBUS;

?>

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
                <td class='col-1'><img src="<?php echo $user->getImage(); ?>" style="width: 50px; height: 50px;" alt="ATR">
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
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                        data-bs-target="#editModal_<?= $user->getId() ?>">
                        <span data-feather="tool"></span>
                    </button>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" id="lockAccountBtn">
                        <span data-feather="lock"></span>
                    </button>
                    <button class="btn btn-sm btn-danger" id='deleteSizeItemBtn' name='deleteSizeItemBtn'>
                        <span data-feather="trash-2"></span>
                    </button>
                </td>
            </tr>
        </tbody>
        <!-- Edit modal TODO: Re-design this:-->
        <div class="modal fade" id="editModal_<?= $user->getId() ?>" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="width: 100%">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Account</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="container-fluid ">

                            <!-- Row 1 -->
                            <div class="row my-2">

                                <!-- Username -->
                                <div class="col">
                                    <label for="editUsername" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="editUsername"
                                        value="<?= $user->getUsername() ?>">
                                </div>

                                <!-- Email -->
                                <div class="col">
                                    <label for="editEmail" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="editEmail" value="<?= $user->getEmail() ?>">
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="row my-2">
                                
                                <!-- Password -->
                                <div class="col">
                                    <label for="editPassword" class="form-label">Password</label>
                                    <input type="password" name="" id="editPassword" class="form-control"
                                        value="<?= $user->getPassword() ?>">
                                </div>

                                <!-- Name -->
                                <div class="col">
                                    <label for="editName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="editName" value="<?= $user->getName() ?>">
                                </div>

                                <!-- Phone -->
                                <div class="col">
                                    <label for="editPhone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="editPhone" value="<?= $user->getPhone() ?>">
                                </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="row my-2">

                                <!-- Gender -->
                                <div class="col">
                                    <label for="editGender" class="form-label">Gender</label>
                                    <select id="editGender" class="form-select">
                                        <option value="1" <?= $user->getGender() == 0 ? 'selected' : '' ?>>Male
                                        </option>
                                        <option value="0" <?= $user->getGender() == 1 ? 'selected' : '' ?>>Female
                                        </option>
                                    </select>
                                </div>

                                <!-- Role -->
                                <div class="col">
                                    <label for="editRole" class="form-label">Role</label>
                                    <select name="" id="editRole" class="form-select">
                                        <option value="1" <?= $user->getRoleId() == 1 ? 'selected' : '' ?>>Admin
                                        </option>
                                        <option value="2" <?= $user->getRoleId() == 2 ? 'selected' : '' ?>>Manager
                                        </option>
                                        <option value="3" <?= $user->getRoleId() == 3 ? 'selected' : '' ?>>Employee
                                        </option>
                                        <option value="4" <?= $user->getRoleId() == 4 ? 'selected' : '' ?>>Customer
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Row 4 -->
                            <div class="row my-2">

                                <!-- Address -->
                                <div class="col">
                                    <label for="editAddress" class="form-label">Address</label>
                                    <input type="text" name="" id="editAddress" class="form-control"
                                        value="<?= $user->getAddress() ?>">
                                </div>
                            </div>

                            <!-- Row 5 -->
                            <div class="row my-2 justify-content-center">

                                <!-- Img -->
                                <div class="col-lg-7">
                                    <label for="editImg"></label>
                                    <input type="file" class="form-control" name="editImgProduct" id="editImg"
                                        accept="image/*">
                                </div>

                                <!-- Preview Image -->
                                <div class="col d-flex justify-content-center">
                                    <img id="editImgPreview" src="<?= $user->getImage() ?>" alt="Preview Image"
                                        class="img-circle border border-black" style="aspect-ratio: 1/1; width: 5rem;">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <?php endforeach; ?>
</table>