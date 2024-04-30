<?php
use backend\bus\CategoriesBUS;
use backend\bus\SizeBUS;
use backend\bus\SizeItemsBUS;
use backend\models\SizeItemsModel;

$title = 'Inventory';
if (!defined('_CODE')) {
    die('Access denied');
}

if (!isAllowToDashBoard()) {
    die('Access denied');
}
include (__DIR__ . '/../inc/head.php');

use backend\bus\ProductBUS;

$productList = ProductBUS::getInstance()->getAllModels();
?>


<body>
    <!-- HEADER -->
    <?php include (__DIR__ . '/../inc/header.php'); ?>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR MENU -->
            <?php include (__DIR__ . '/../inc/sidebar.php'); ?>

            <!-- MAIN -->
            <main class="col-9 ms-sm-auto col-lg-10 px-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <?= $title ?>
                    </h1>

                    <div class="btn-toolbar mb-2 mb-0">
                        <button type="button" class="btn btn-sm btn-success align-middle" data-bs-toggle="modal"
                            data-bs-target="#addModal" id="addSizeItem" class="addBtn">
                            <span data-feather="plus"></span>
                            Add
                        </button>
                    </div>
                </div>

                <form method="POST" style="width: 70%;">
                    <div class="search-group input-group">
                        <input type="text" id="productSearch" class="searchInput form-control" name="searchValue"
                            placeholder="Search product name here...">
                        <button type="submit" class="btn btn-sm btn-primary align-middle padx-0 pady-0"
                            name="searchBtnName" id="searchBtnId">
                            <span data-feather="search"></span>
                        </button>
                    </div>
                </form>

                <table class="table align-middle table-borderless table-hover">
                    <thead class="table-light">
                        <tr class="align-middle">
                            <th></th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                    if (!isPost() || (!isPost() && !isset($_POST['searchBtnName']))) {
                        $products = SizeItemsBUS::getInstance()->getAllModels();
                        $groupedProducts = [];

                        // Group products by their ID
                        foreach ($products as $product) {
                            $productId = $product->getProductId();
                            if (!isset($groupedProducts[$productId])) {
                                $groupedProducts[$productId] = [
                                    'product' => ProductBUS::getInstance()->getModelById($productId),
                                    'sizes' => []
                                ];
                            }
                            $groupedProducts[$productId]['sizes'][] = $product;
                        }

                        // Now iterate over the grouped products
                        foreach ($groupedProducts as $groupedProduct):
                            $product = $groupedProduct['product'];
                            $sizes = $groupedProduct['sizes'];
                            ?>
                            <tbody>
                                <?php foreach ($sizes as $size): ?>
                                    <tr>
                                        <td><img src='<?php echo $product->getImage(); ?>' alt='' class='rounded float-start'>
                                        </td>
                                        <td><?php echo $product->getName(); ?></td>
                                        <td>
                                            <?php $categoryName = CategoriesBUS::getInstance()->getModelById($product->getCategoryId())->getName(); ?>
                                            <?php echo $categoryName; ?>
                                        </td>
                                        <td>
                                            <?php echo preg_replace('/[^0-9]/', '', SizeBUS::getInstance()->getModelById($size->getSizeId())->getName()); ?><br>
                                        </td>
                                        <td>
                                            <?php echo $size->getQuantity(); ?><br>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editQuantityModal_<?= $product->getId() ?>_<?= $size->getSizeId() ?>">
                                                <span data-feather="tool"></span>
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                id='deleteSizeItemBtn_<?= $product->getId() ?>_<?= $size->getSizeId() ?>'
                                                name='deleteSizeItemBtn'>
                                                <span data-feather="trash-2"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- edit quantity modal -->
                                    <div class="modal fade"
                                        id="editQuantityModal_<?= $product->getId() ?>_<?= $size->getSizeId() ?>" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form id="form_<?= $product->getId() ?>_<?= $size->getSizeId() ?>">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Size Quantity</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="inputSize" class="form-label">Size</label>
                                                        <input type="text" name="inputSize" id="inputSize" class="form-control"
                                                            value="<?= preg_replace('/[^0-9]/', '', SizeBUS::getInstance()->getModelById($size->getSizeId())->getName()) ?>"
                                                            readonly>

                                                        <label
                                                            for="inputQuantity_<?= $product->getId() ?>_<?= $size->getSizeId() ?>"
                                                            class="form-label">Current
                                                            Quantity</label>
                                                        <input type="number" name="inputQuantity"
                                                            id="inputQuantity_<?= $product->getId() ?>_<?= $size->getSizeId() ?>"
                                                            class="form-control" value="<?= $size->getQuantity() ?>" readonly>

                                                        <label
                                                            for="inputNewQuantity_<?= $product->getId() ?>_<?= $size->getSizeId() ?>"
                                                            class="form-label">New Quantity</label>
                                                        <input type="number" name="inputNewQuantity"
                                                            id="inputNewQuantity_<?= $product->getId() ?>_<?= $size->getSizeId() ?>"
                                                            class="form-control">
                                                        <p class="text-danger"> Tip: Negative number for decreasing quantity, else
                                                            increasing quantity from
                                                            current quantity</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        <?php endforeach; ?>
                        </tbody>
                    <?php } else if (isPost() && isset($_POST['searchBtnName'])) {
                        $searchValue = $_POST['searchValue'];
                        if (empty($searchValue) || trim($searchValue) == '') {
                            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
                            echo "Please input the search bar to search!";
                            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' onclick='window.history.back(); aria-label='Close'></button>";
                            echo "</div>";
                        }

                        $products = ProductBUS::getInstance()->searchModel($searchValue, ['name']);
                        if (count($products) == 0 && !empty($searchValue)) {
                            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
                            echo "No product found!";
                            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' onclick='window.history.back(); aria-label='Close'></button>";
                            echo "</div>";
                        }
                        $groupedProducts = [];

                        // Group products by their ID
                        foreach ($products as $product) {
                            $productId = $product->getId();
                            $sizes = SizeItemsBUS::getInstance()->getModelByProductId($productId);
                            if (!isset($groupedProducts[$productId])) {
                                $groupedProducts[$productId] = [
                                    'product' => $product,
                                    'sizes' => $sizes
                                ];
                            }
                        }

                        // Now iterate over the grouped products
                        foreach ($groupedProducts as $groupedProduct):
                            $product = $groupedProduct['product'];
                            $sizes = $groupedProduct['sizes'];
                            ?>
                                <tbody>
                                <?php foreach ($sizes as $size): ?>
                                        <tr>
                                            <td><img src='<?php echo $product->getImage(); ?>' alt='' class='rounded float-start'>
                                            </td>
                                            <td><?php echo $product->getName(); ?></td>
                                            <td>
                                            <?php $categoryName = CategoriesBUS::getInstance()->getModelById($product->getCategoryId())->getName(); ?>
                                            <?php echo $categoryName; ?>
                                            </td>
                                            <td>
                                            <?php echo preg_replace('/[^0-9]/', '', SizeBUS::getInstance()->getModelById($size->getSizeId())->getName()); ?><br>
                                            </td>
                                            <td>
                                            <?php echo $size->getQuantity(); ?><br>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editQuantityModal_<?= $product->getId() ?>_<?= $size->getSizeId() ?>">
                                                    <span data-feather="tool"></span>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    id='deleteSizeItemBtn_<?= $product->getId() ?>_<?= $size->getSizeId() ?>'
                                                    name='deleteSizeItemBtn'>
                                                    <span data-feather="trash-2"></span>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- edit quantity modal -->
                                        <div class="modal fade"
                                            id="editQuantityModal_<?= $product->getId() ?>_<?= $size->getSizeId() ?>" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form id="form_<?= $product->getId() ?>_<?= $size->getSizeId() ?>">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Size Quantity</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label for="inputSize" class="form-label">Size</label>
                                                            <input type="text" name="inputSize" id="inputSize" class="form-control"
                                                                value="<?= preg_replace('/[^0-9]/', '', SizeBUS::getInstance()->getModelById($size->getSizeId())->getName()) ?>"
                                                                readonly>

                                                            <label
                                                                for="inputQuantity_<?= $product->getId() ?>_<?= $size->getSizeId() ?>"
                                                                class="form-label">Current
                                                                Quantity</label>
                                                            <input type="number" name="inputQuantity"
                                                                id="inputQuantity_<?= $product->getId() ?>_<?= $size->getSizeId() ?>"
                                                                class="form-control" value="<?= $size->getQuantity() ?>" readonly>

                                                            <label
                                                                for="inputNewQuantity_<?= $product->getId() ?>_<?= $size->getSizeId() ?>"
                                                                class="form-label">New Quantity</label>
                                                            <input type="number" name="inputNewQuantity"
                                                                id="inputNewQuantity_<?= $product->getId() ?>_<?= $size->getSizeId() ?>"
                                                                class="form-control">
                                                            <p class="text-danger"> Tip: Negative number for decreasing quantity, else
                                                                increasing quantity from
                                                                current quantity</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                <?php endforeach; ?>
                                </tbody>
                        <?php endforeach; ?>
                            </tbody>
                        <?php

                    } ?>
                </table>

                <!-- Add modal -->
                <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Item</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3">
                                    <div class="col-7">
                                        <label for="inputProductName" class="form-label">Product Name</label>
                                        <select id="inputProductName" class="form-select" name="productName">
                                            <?php
                                            $productsListChecking = ProductBUS::getInstance()->getAllModels();
                                            $sizeListChecking = SizeBUS::getInstance()->getAllModels();
                                            $sizeItemsListChecking = SizeItemsBUS::getInstance()->getAllModels();
                                            $allProductsFullyAssigned = true;
                                            $assignedProducts = [];
                                            foreach ($sizeItemsListChecking as $sizeItem) {
                                                $assignedProducts[$sizeItem->getProductId()][] = $sizeItem->getSizeId();
                                            }

                                            foreach ($productsListChecking as $product) {
                                                $isFullyAssigned = true;
                                                foreach ($sizeListChecking as $size) {
                                                    if (!isset($assignedProducts[$product->getId()]) || !in_array($size->getId(), $assignedProducts[$product->getId()])) {
                                                        $isFullyAssigned = false;
                                                        break;
                                                    }
                                                }
                                                if (!$isFullyAssigned) {
                                                    echo "<option value='" . $product->getId() . "'>" . $product->getName() . "</option>";
                                                    $allProductsFullyAssigned = false;
                                                }
                                            }

                                            if ($allProductsFullyAssigned) {
                                                echo "<option value=''>None</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <label for="inputSize" class="form-label">Sizes</label>
                                        <select id="inputSizeId" class="form-select" name="size">
                                            <?php
                                            $sizeList1 = SizeBUS::getInstance()->getAllModels();
                                            foreach ($sizeList1 as $size1) {
                                                echo "<option value='" . preg_replace(' /[^0-9]/', '', $size1->getId()) .
                                                    "'>" . $size1->getName() . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="inputPrice" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="inputQuantity" name="quantity">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="saveButton"
                                    name="saveBtnName">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php
            //TODO: Fix notification not showing up.
            if (isPost()) {
                //Handle add size item:
                if (isset($_POST['saveBtnName'])) {
                    $productId = $_POST['productName'];
                    $sizeId = $_POST['size'];
                    $quantity = $_POST['quantity'];
                    $checkingAssignedSizeItem = SizeItemsBUS::getInstance()->getModelBySizeIdAndProductId($sizeId, $productId);

                    if ($checkingAssignedSizeItem != null) {
                        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
                        echo "This size is already assigned to this product!";
                        echo "<button type='button' class='btn-close' data-bs-dismiss='alert' onclick='window.history.back(); aria-label='Close'></button>";
                        echo "</div>";
                        $checkingAssignedSizeItem->setQuantity($checkingAssignedSizeItem->getQuantity() + $quantity);
                        SizeItemsBUS::getInstance()->updateModel($checkingAssignedSizeItem);
                        SizeItemsBUS::getInstance()->refreshData();
                    }

                    $newSizeItemModel = new SizeItemsModel(null, $productId, $sizeId, $quantity);
                    SizeItemsBUS::getInstance()->addModel($newSizeItemModel);
                    SizeItemsBUS::getInstance()->refreshData();
                }
                //Handle update quantity:
                if (isset($_POST['button'])) {
                    $productId = $_POST['productId'];
                    $sizeId = $_POST['sizeId'];
                    $newQuantity = $_POST['newQuantity'];
                    $currentQuantity = $_POST['currentQuantity'];
                    $sizeItem = SizeItemsBUS::getInstance()->getModelBySizeIdAndProductId($sizeId, $productId);
                    $sizeItem->setQuantity($currentQuantity + $newQuantity);
                    SizeItemsBUS::getInstance()->updateModel($sizeItem);
                    SizeItemsBUS::getInstance()->refreshData();
                }
                //Handle delete size item:
                if (isset($_POST['delete'])) {
                    $productId = $_POST['productId'];
                    $sizeId = $_POST['sizeId'];
                    $sizeItem = SizeItemsBUS::getInstance()->getModelBySizeIdAndProductId($sizeId, $productId);
                    SizeItemsBUS::getInstance()->deleteModel($sizeItem);
                    SizeItemsBUS::getInstance()->refreshData();
                }
            }
            ?>


            <?php include (__DIR__ . '/../inc/app/app.php'); ?>
            <script src="https://kit.fontawesome.com/2a9b643027.js" crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/dashboard/add_sizeitem.js"></script>
            <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/dashboard/update_sizeitem.js"></script>
            <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/dashboard/delete_sizeitem.js"></script>

</body>