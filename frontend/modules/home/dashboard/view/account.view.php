<?php
    $title = 'Accounts';

    include ('../inc/head.php');

    // Namespace
    use backend\bus\OrdersBUS;
    use backend\bus\OrderItemsBUS;
?>

<body>
    <!-- HEADER -->
    <?php include ('../inc/header.php'); ?>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR MENU -->
            <?php include ('../inc/sidebar.php'); ?>

            <!-- MAIN -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <?= $title ?>
                    </h1>
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
                            <th>Password</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Manage</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class='col-1'><img src="https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg" alt=""></td>
                            <td class='col-1'>Username</td>
                            <td class='col-1'>Passwords</td>
                            <td class='col-2'>Nguyen Van A</td>
                            <td class='col-1'>Email@gmail.codawda234m</td>
                            <td class='col-1'>0123456789</td>
                            <td class="col-2">273 An Duong Vuong, Phuong 3, Quan 5, TP HCM</td>
                            <td class='col-1'>Admin</td>
                            <td class='col-1'>Active</td>
                            <td class='col-2 userAction'>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
                                            <span data-feather="lock"></span>
                                            Lock
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                            <span data-feather="trash-2"></span>
                                            Delete
                                    </button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </main>

            <!-- Add modal -->
            <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="width: 100%">
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
                                    <input type="text" class="form-control" id="inputUsername">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPassword" class="form-label">Password</label>
                                    <input type="text" name="" id="inputPassword" class="form-control">
                                </div>
                                <div class="col-5">
                                    <label for="inputEmail" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="inputEmail" >
                                </div>
                                <div class="col-5">
                                    <label for="inputName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="inputName" >
                                </div>
                                <div class="col-3">
                                    <label for="inputPhone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="inputPhone" >
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
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputAddress" class="form-label">Address</label>
                                    <input type="text" name="" id="inputAddress" class="form-control">
                                </div>
                                <div class="col-6  userImg">
                                <img id="imgPreview" src="..\..\..\..\templates\images\680098.jpg" alt="Preview Image"a class="img-circle">
                                </div>
                                <div class="col-6">
                                    <label for="inputImg">Img</label>
                                    <input type="file" class="form-control" name="imgProduct" id="inputImg" accept="image/*">
                                </div>
                            

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>


            <?php include('../inc/app/app.php'); ?>
            
</body>

</html>