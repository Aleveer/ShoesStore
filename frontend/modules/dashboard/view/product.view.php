<?php
$title = 'Product';
if (!defined('_CODE')) {
    die('Access denied');
}

if (!isAllowToDashBoard()) {
    die('Access denied');
}
include(__DIR__ .'/../inc/head.php');

use backend\bus\ProductBUS;

$productList = ProductBUS::getInstance()->getAllModels();
?>

<body>
    <!-- HEADER -->
    <?php include(__DIR__ .'/../inc/header.php'); ?>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR MENU -->
            <?php include(__DIR__ .'/../inc/sidebar.php'); ?>

            <!-- MAIN -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <?= $title ?>
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-success align-middle" data-bs-toggle="modal" data-bs-target="#addModal" id="addProduct" class="addBtn">
                            <span data-feather="plus"></span>
                            Add
                        </button>
                    </div>
                </div>
                <?php include('product.table.php') ?>
            </main>


            <!-- Add modal -->
            <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="width: 100%">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Product</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3">
                                <div class="col-md-7">
                                    <label for="inputProductName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="inputProductName">
                                </div>
                                <div class="col-md-5">
                                    <label for="inputProductCate" class="form-label">Categories</label>
                                    <select id="inputProductCate" class="form-select">
                                        <option value="1">Running Shoes</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="inputPrice" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="inputPrice">
                                </div>
                                <div class="col-md-4">
                                    <label for="inputGender" class="form-label">Gender</label>
                                    <select id="inputGender" class="form-select">
                                        <option value="1" selected>Male</option>
                                        <option value="0">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <label for="inputPhone" class="form-label">Description</label>
                                    <textarea class="form-control" id="w3review" name="w3review" row="1" cols="40"></textarea>
                                </div>

                                <div class="col-7">
                                    <label for="inputImg">Img</label>
                                    <input type="file" class="form-control" name="imgProduct" id="inputImg" accept="image/*">
                                </div>

                                <div class="col-5 productImg">
                                    <img id="imgPreview" src="..\..\..\..\templates\images\680098.jpg" alt="Preview Image">
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


            <!-- Edit modal -->
            <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Product</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3">
                                <div class="col-md-7">
                                    <label for="inputProductName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="inputProductName">
                                </div>
                                <div class="col-md-5">
                                    <label for="inputProductCate" class="form-label">Categories</label>
                                    <select id="inputProductCate" class="form-select">
                                        <option value="1">Running Shoes</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="inputPrice" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="inputPrice">
                                </div>
                                <div class="col-md-4">
                                    <label for="inputGender" class="form-label">Gender</label>
                                    <select id="inputGender" class="form-select">
                                        <option value="1" selected>Male</option>
                                        <option value="0">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <label for="inputPhone" class="form-label">Description</label>
                                    <textarea class="form-control" id="w3review" name="w3review" row="1" cols="40"></textarea>
                                </div>

                                <div class="col-7">
                                    <label for="inputImg">Img</label>
                                    <input type="file" class="form-control" name="imgProduct" id="inputImg" accept="image/*">
                                </div>

                                <div class="col-5 productImg">
                                    <img id="imgPreview" src="..\..\..\..\templates\images\680098.jpg" alt="Preview Image" class="form-image">
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php include(__DIR__ . '/../inc/app/app.php'); ?>
            <script src="https://kit.fontawesome.com/2a9b643027.js" crossorigin="anonymous"></script>

</body>

</html>