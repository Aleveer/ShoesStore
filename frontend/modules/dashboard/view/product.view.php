<?php
use backend\bus\CategoriesBUS;
use backend\models\ProductModel;

$title = 'Product';
if (!defined('_CODE')) {
    die('Access denied');
}

if (!isAllowToDashBoard()) {
    die('Access denied');
}
include (__DIR__ . '/../inc/head.php');

use backend\bus\ProductBUS;

$productList = ProductBUS::getInstance()->getAllModels();

function showProductList($product)
{
    echo "<tr>";
    echo "<td class='col-1'><img src='" . $product->getImage() . "' alt='" . $product->getName() . "' class='rounded float-start'></td>";
    echo "<td class='col-1'>" . $product->getId() . "</td>";
    echo "<td class='col-3'>" . $product->getName() . "</td>";
    echo "<td class='col-2'>" . CategoriesBUS::getInstance()->getModelById($product->getCategoryId())->getName() . "</td>";
    echo "<td class='col-4'>" . $product->getDescription() . "</td>";
    echo "<td class='col-1'>" . $product->getPrice() . "</td>";
    echo "<td class='col-1'>";
    echo "<div class='product-action'>";
    echo "<a href='http://localhost/frontend/index.php?module=dashboard&view=product.update&id=" . $product->getId() . "' class='btn btn-sm btn-warning'>";
    echo "<span data-feather='tool'></span>";
    echo "</a>";
    echo "<button class='btn btn-sm btn-danger'>";
    echo "<span data-feather='trash-2'></span>";
    echo "</button>";
    echo "</div>";
    echo "</td>";
    echo "</tr>";
}
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

                    <form action="" method="POST">
                        <div class="search-group input-group">
                            <input type="text" name="productSearch" id="productSearchBar"
                                class="searchInput form-control">
                            <button type="submit" id="productSearchButton" name="productSearchButtonName"
                                class="btn btn-sm btn-primary align-middle padx-0 pady-0">
                                <span data-feather="search"></span>
                            </button>
                        </div>
                    </form>

                    <div class="btn-toolbar mb-2 mb-0">
                        <button type="button" class="btn btn-sm btn-success align-middle" data-bs-toggle="modal"
                            data-bs-target="#addModal" id="addProduct" class="addBtn">
                            <span data-feather="plus"></span>
                            Add
                        </button>
                    </div>
                </div>
                <table class="table align-middle table-borderless table-hover">
                    <thead class="table-light">
                        <tr class="align-middle">
                            <th></th>
                            <th>Id</th>
                            <th>Product Name</th>
                            <th>Categories</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        //By default, the product list shows all: 
                        if (!isPost() || (isPost() && !isset($_POST['productSearchButtonName']))) {
                            foreach ($productList as $product): ?>
                                <!-- <tr>
                                <td class='col-1'><img src='<?php echo $product->getImage(); ?>'
                                        alt='<?php echo $product->getName(); ?>' class='rounded float-start'>
                                </td>
                                <td class='col-3'><?= $product->getName() ?></td>
                                <td class='col-2'><?= $product->getCategoryId() ?></td>
                                <td class='col-4'><?= $product->getDescription() ?></td>
                                <td class='col-1'><?= $product->getPrice() ?></td>
                                <td class='col-1'>
                                    <div class='product-action'>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <span data-feather="tool"></span>
                                            Update
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <span data-feather="trash-2"></span>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr> -->
                                <?= showProductList($product); ?>
                            <?php endforeach;
                        } ?>
                        <?php
                        if (isPost()) {
                            $filterAll = filter();
                            if (isset($_POST['productSearchButtonName'])) {
                                $searchQuery = $_POST['productSearch'];
                                if (empty($searchQuery)) {
                                    echo '
                <script>
                alert("Search cannot be empty!");
                window.location.href = "?module=dashboard&view=product.view";
                </script>';
                                } else {
                                    $searchResultFromSearchBar = ProductBUS::getInstance()->searchModel($searchQuery, ['id', 'name', 'price', 'description']);

                                    // Check if searchModel returned any results
                                    if (empty($searchResultFromSearchBar)) {
                                        echo '<script>alert("No results found for your search.");</script>';
                                    } else {
                                        //Filter $productList to only show products that matched the search results:
                                        $searchFinal = array();
                                        foreach ($productList as $product) {
                                            foreach ($searchResultFromSearchBar as $searchResult) {
                                                if ($product->getId() == $searchResult->getId()) {
                                                    array_push($searchFinal, $product);
                                                }
                                            }
                                        }

                                        // Check if any products matched the search results
                                        if (empty($searchFinal)) {
                                            echo '<script>alert("No matching products found.");</script>';
                                        } else {
                                            foreach ($searchFinal as $product) {
                                                showProductList($product);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>


                <!-- Add modal -->
                <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Product</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3">
                                    <div class="col-7">
                                        <label for="inputProductName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="inputProductName"
                                            name="productName">
                                    </div>
                                    <div class="col-5">
                                        <label for="inputProductCate" class="form-label">Categories</label>
                                        <select id="inputProductCate" class="form-select" name="category">
                                            <?php $categoriesList = CategoriesBUS::getInstance()->getAllModels();
                                            foreach ($categoriesList as $categories) {
                                                echo "<option value='" . $categories->getId() . "'>" . $categories->getName() . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="inputPrice" class="form-label">Price</label>
                                        <input type="text" class="form-control" id="inputPrice" name="price">
                                    </div>
                                    <div class="col-4">
                                        <label for="inputGender" class="form-label">Gender</label>
                                        <select id="inputGender" class="form-select" name="gender">
                                            <option value="0" selected>Male</option>
                                            <option value="1">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-7">
                                        <label for="inputPhone" class="form-label">Description</label>
                                        <textarea class="form-control" id="w3review" name="description" row="1"
                                            cols="40"></textarea>
                                    </div>
                                    <div class="col-7">
                                        <label for="inputImg">Image (.JPG, .JPEG, .PNG)</label>
                                        <input type="file" class="form-control" name="image" id="inputImg"
                                            accept=".jpg, .jpeg, .png">
                                    </div>
                                    <div class="col-5 productImg">
                                        <img id="imgPreview" src="..\..\..\..\templates\images\680098.jpg"
                                            alt="Preview Image">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="saveButton"
                                    name="saveBtnName">Save</button>
                            </div>
                            <?php
                            if (isPost()) {
                                if (isset($_POST['saveBtn'])) {
                                    $productName = $_POST['productName'];
                                    $productCategory = $_POST['category'];
                                    $productPrice = $_POST['price'];
                                    $productGender = $_POST['gender'];
                                    $productDescription = $_POST['description'];

                                    $productModel = new ProductModel(null, $productName, $productCategory, $productPrice, $productDescription, null, $productGender);
                                    $data = $_POST['image'];
                                    $productModel->setImage($data);

                                    ProductBUS::getInstance()->addModel($productModel);
                                    ProductBUS::getInstance()->refreshData();
                                    //Once created, refresh the page:
                                    echo '<script>window.location.href = "?module=dashboard&view=product.view";</script>';
                                }
                            }
                            ?>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- add size modal -->
                <div class="modal fade" id="addSizeModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Size</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="inputSize" class="form-label">Size</label>
                                <input type="text" name="inputSize" id="inputSize" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include (__DIR__ . '/../inc/app/app.php'); ?>
                <script src="https://kit.fontawesome.com/2a9b643027.js" crossorigin="anonymous"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/dashboard/add_product.js"></script>
</body>

</html>