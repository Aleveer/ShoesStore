<?php
use backend\bus\ProductBUS;
use backend\bus\SizeBUS;
use backend\bus\SizeItemsBUS;
use backend\bus\CategoriesBUS;
use backend\services\session;

$categoriesList = CategoriesBUS::getInstance()->getAllModels();
$size = SizeBUS::getInstance()->getAllModels();
$sizeItems = SizeItemsBUS::getInstance()->getAllModels();
$products = ProductBUS::getInstance()->getAllModels();

global $searchResult;
global $resultsBasedOnPrice;

?>

<?php
function displayProduct($product)
{
    echo '
        <div class="pitem">
            <div class="imgitem">
                <img src="' . $product->getImage() . '" alt="">
            </div>
            <div class="content">
                <div class="name">' . $product->getName() . '</div>
                <div class="price">' . $product->getPrice() . '<sup>đ</sup></div>
                <button class="see_product">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <a href="?module=indexphp&action=singleproduct&id=' . $product->getId() . '">SEE MORE</a>
                </button>
            </div>
        </div>
        ';
}
?>

<div id="header">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/css/product.css" />
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/css/product_slider.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php layouts("header") ?>
</div>

<div id="content">
    <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/product_filter.js"></script>
    <div class="carousel">
        <div class="list">
            <div class="item active">
                <img src="<?php echo _WEB_HOST_TEMPLATE ?>/images/680098.jpg" alt="">
                <div class="content">
                    <div class="author">My Shoes Store</div>
                    <div class="title">FILLO</div>
                    <div class="topic">Introduce</div>
                    <div class="des">
                        Nơi mà niềm đam mê thể thao và phong cách thời trang hiện đại hòa quyện.
                        Không chỉ là một điểm bán giày, mà còn là nguồn cảm hứng cho những người yêu thể thao.
                    </div>
                    <div class="buttons">
                        <button>SUBCRIBE</button>
                        <button>CONTACT US</button>
                    </div>
                </div>
            </div>

            <div class="item">
                <img src="<?php echo _WEB_HOST_TEMPLATE ?>/images/680102.jpg" alt="">
                <div class="content">
                    <div class="author">My Shoes Store</div>
                    <div class="title">FILLO</div>
                    <div class="topic">Introduce</div>
                    <div class="des">
                        Cam kết mang đến cho bạn những đôi giày chất lượng cao, từ các thương hiệu nổi tiếng như
                        Nike,
                        Adidas, và Puma, đến những thương hiệu mới nổi đầy sáng tạo.
                    </div>
                    <div class="buttons">
                        <button>SUBCRIBE</button>
                        <button>CONTACT US</button>
                    </div>
                </div>
            </div>

            <div class="item">
                <img src="<?php echo _WEB_HOST_TEMPLATE ?>/images/Air-Jordan-Shoes-Photo.jpg" alt="">
                <div class="content">
                    <div class="author">My Shoes Store</div>
                    <div class="title">FILLO</div>
                    <div class="topic">Introduce</div>
                    <div class="des">
                        Mỗi đôi giày tại cửa hàng đều được chọn lọc kỹ càng, đảm bảo sự thoải mái, độ bền và phong
                        cách.
                        Với đa dạng mẫu mã và màu sắc, bạn chắc chắn sẽ tìm thấy đôi giày phù hợp với mình.
                    </div>
                    <div class="buttons">
                        <button>SUBCRIBE</button>
                        <button>CONTACT US</button>
                    </div>
                </div>
            </div>

            <div class="item">
                <img src="<?php echo _WEB_HOST_TEMPLATE ?>/images/Air-Jordan-Shoes-Picture.jpg" alt="">
                <div class="content">
                    <div class="author">My Shoes Store</div>
                    <div class="title">FILLO</div>
                    <div class="topic">Introduce</div>
                    <div class="des">
                        Đội ngũ nhân viên thân thiện và chuyên nghiệp của chúng tôi luôn sẵn sàng tư vấn để bạn có
                        thể
                        chọn được đôi giày tốt nhất.
                        Chính sách đổi trả linh hoạt và dịch vụ sau bán hàng chu đáo sẽ làm bạn hài lòng.
                    </div>
                    <div class="buttons">
                        <button>SUBCRIBE</button>
                        <button>CONTACT US</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="thumbnail">
            <div class="item">
                <img src="<?php echo _WEB_HOST_TEMPLATE ?>/images/680102.jpg" alt="">
                <div class="content">
                    <div class="title">FILLO</div>
                    <div class="des">Tôn Chỉ</div>
                </div>
            </div>

            <div class="item">
                <img src="<?php echo _WEB_HOST_TEMPLATE ?>/images/Air-Jordan-Shoes-Photo.jpg" alt="">
                <div class="content">
                    <div class="title">FILLO</div>
                    <div class="des">Đặc Điểm</div>
                </div>
            </div>

            <div class="item">
                <img src="<?php echo _WEB_HOST_TEMPLATE ?>/images/Air-Jordan-Shoes-Picture.jpg" alt="">
                <div class="content">
                    <div class="title">FILLO</div>
                    <div class="des">Dịch Vụ</div>
                </div>
            </div>

            <div class="item active">
                <img src="<?php echo _WEB_HOST_TEMPLATE ?>/images/680098.jpg" alt="">
                <div class="content">
                    <div class="title">FILLO</div>
                    <div class="des">FILLO Slogan</div>
                </div>
            </div>
        </div>

        <div class="arrows">
            <button id="prev">
                < </button>
                    <button id="next"> > </button>
        </div>
    </div>

    <div class="con_product">
        <form method="POST">
            <div class="psearch">
                <input type="text" name="searchbox" placeholder="Nhập sản phẩm bạn muốn tìm kiếm" required>
                <button class="custom-btn btn-14" name="searchBtn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
        <?php
        if (isPost()) {
            $filterAll = filter();
            $searchQuery = isset($filterAll['searchbox']) ? $filterAll['searchbox'] : '';
            $searchResult = array();
            if ($searchQuery !== '') {
                $searchResult = ProductBUS::getInstance()->searchModel($searchQuery, ['name']);
                if (count($searchResult) == 0) {
                    echo '<script>alert("Không tìm thấy sản phẩm với nội dung ' . $searchQuery . '")</script>';
                } else {
                    echo '<div class="search_result">Search results for "' . $searchQuery . '"</div>';
                }
            }
        }
        ?>
        <div class="container_filter_pagination">
            <form id="filterForm" method="POST" action="">
                <div class="filter">
                    <fieldset>
                        <legend>Category</legend>
                        <input type="radio" name="category" value="All products" onchange="this.form.submit()">All
                        products
                        <br>
                        <?php
                        foreach ($categoriesList as $category) {
                            echo '<input type="radio" name="category" value="' . $category->getName() . '"onchange="this.form.submit()">' . $category->getName() . '<br>';
                        }
                        ?>
                    </fieldset>
                    <fieldset>
                        <legend>Gender</legend>
                        <input type="radio" name="gender" value="Male" onchange="this.form.submit()">Male
                        <br>
                        <input type="radio" name="gender" value="Female" onchange="this.form.submit()">Female
                    </fieldset>
                    <fieldset>
                        <legend>Price</legend>
                        <label for="min_price">Minimum Price:</label>
                        <input type="number" name="min_price" min="0" placeholder="100000">
                        <br>
                        <label for="max_price">Maximum Price:</label>
                        <input type="number" name="max_price" min="<?php echo $_POST['min_price'] ?? '' ?>"
                            placeholder="100000">
                    </fieldset>
                </div>
                <button type="submit" name="submitBtn">Submit</button>
            </form>
            <div class="container_pagination">
                <div class="sort">
                    <label for="alphabet">Chữ Cái:</label>
                    <select name="alphabet">
                        <option value="A_Z">A-Z</option>
                        <option value="Z_A">Z_A</option>
                    </select>
                    <label for="price">Theo giá:</label>
                    <select>
                        <option value="high">High</option>
                        <option value="low">Low</option>
                    </select>
                </div> 
                <div class="areaproduct">
                    <?php
                    if (isPost()) {

                        $filterAll = filter();
                        $minimalPrice = $filterAll['min_price'] ?? null;
                        $maximalPrice = $filterAll['max_price'] ?? null;
                        $resultsBasedOnPrice = array();
                        $errors = array();

                        if ($minimalPrice != null && $maximalPrice != null) {
                            if ($minimalPrice > $maximalPrice) {
                                $errors[] = "Giá tối thiểu không được lớn hơn giá tối đa";
                            } elseif ($minimalPrice < 0) {
                                $errors[] = "Giá tối thiểu không được nhỏ hơn 0";
                            } elseif ($maximalPrice < 0) {
                                $errors[] = "Giá tối đa không được nhỏ hơn 0";
                            } elseif ($maximalPrice == $minimalPrice) {
                                $errors[] = "Giá tối đa không được bằng giá tối thiểu";
                            } elseif ($maximalPrice < $minimalPrice) {
                                $errors[] = "Giá tối đa không được nhỏ hơn giá tối thiểu";
                            } elseif ($maximalPrice < 0 && $minimalPrice < 0) {
                                $errors[] = "Giá tối đa và giá tối thiểu không được nhỏ hơn 0";
                            } elseif ($maximalPrice == $minimalPrice && $maximalPrice < 0 && $minimalPrice < 0) {
                                $errors[] = "Giá tối đa và giá tối thiểu không được nhỏ hơn 0 và bằng nhau";
                            } elseif ($maximalPrice == $minimalPrice && $maximalPrice < 0) {
                                $errors[] = "Giá tối đa và giá tối thiểu không được nhỏ hơn 0 và bằng nhau";
                            } elseif ($maximalPrice == $minimalPrice && $minimalPrice < 0) {
                                $errors[] = "Giá tối đa và giá tối thiểu không được nhỏ hơn 0 và bằng nhau";
                            }
                        }

                        if (!empty($errors)) {
                            foreach ($errors as $error) {
                                session::getInstance()->setFlashData("error", $error);
                                session::getInstance()->setFlashData("price", "error");
                            }
                        }

                        if ($maximalPrice != null && $minimalPrice != null) {
                            $resultsBasedOnPrice = ProductBUS::getInstance()->searchBetweenPrice($minimalPrice, $maximalPrice);
                        }

                        if ($maximalPrice != null && $minimalPrice == null) {
                            $resultsBasedOnPrice = ProductBUS::getInstance()->searchByMaximalPrice($maximalPrice);
                        }

                        if ($maximalPrice == null && $minimalPrice != null) {
                            $resultsBasedOnPrice = ProductBUS::getInstance()->searchByMinimalPrice($minimalPrice);
                        }
                    }
                    ?>
                    <?php
                    $filteredProducts = array();
                    if (isPost()) {
                        $filterAll = filter();
                        $selectedCategory = $filterAll['category'] ?? null;
                        $selectedGender = $filterAll['gender'] ?? null;

                        if ($selectedGender == "Male") {
                            $selectedGender = 0;
                        } else if ($selectedGender == "Female") {
                            $selectedGender = 1;
                        }

                        // Only call searchModel if $selectedCategory is not null
                        if ($selectedCategory != null && $selectedCategory != "All products") {
                            $categoryModel = CategoriesBUS::getInstance()->getModelByName($selectedCategory);
                            $filteredProducts = array_filter($products, function ($product) use ($categoryModel, $selectedGender) {
                                if ($categoryModel != null && $product->getCategoryId() != $categoryModel->getId()) {
                                    return false;
                                }
                                if ($selectedGender != null && $product->getGender() != $selectedGender) {
                                    return false;
                                }
                                return true;
                            });
                        } else {
                            $filteredProducts = array_filter($products, function ($product) use ($selectedGender) {
                                if ($selectedGender != null && $product->getGender() != $selectedGender) {
                                    return false;
                                }
                                return true;
                            });
                        }

                        if ($selectedCategory == "All products") {
                            $filteredProducts = $products;
                        }

                        // If no products are found, display a message
                        if (count($filteredProducts) == 0) {
                            echo '<div class="no_products">No products found</div>';
                        }

                        // If no filters are selected, display all products
                        if (($selectedCategory == null || $selectedCategory == "All products") && $selectedGender == null) {
                            $filteredProducts = $products;
                        }
                    }

                    if ($searchResult !== null && count($searchResult) > 0 && isset($_POST['searchbox'])) {
                        $productsToDisplay = $searchResult;
                    } else if ($resultsBasedOnPrice !== null && count($resultsBasedOnPrice) > 0) {
                        $productsToDisplay = $resultsBasedOnPrice;
                    } elseif (
                        isset($_POST['category']) || isset($_POST['gender'])
                        || (isset($_POST['min_price']) && isset($_POST['max_price']))
                        || (!isset($_POST['min_price']) && isset($_POST['max_price']))
                        || (isset($_POST['min_price']) && !isset($_POST['max_price']))
                    ) {
                        $productsToDisplay = $filteredProducts;
                    } else {
                        $productsToDisplay = $products;
                    }

                    foreach ($productsToDisplay as $product) {
                        displayProduct($product);
                    }

                    ?>
                </div>
                <div class="page">
                    <button class="custom-btn btn-7 prev"><span>
                            < </span></button>
                    <button class="custom-btn btn-7 next"><span> > </span></button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/product_slider.js"></script>
</div>

<div id="footer">
    <?php layouts("footer") ?>
</div>