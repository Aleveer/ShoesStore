<?php
use backend\bus\ProductBUS;
use backend\bus\SizeBUS;
use backend\bus\SizeItemsBUS;
use backend\bus\CategoriesBUS;
use backend\services\session;

global $id;
$categoriesList = CategoriesBUS::getInstance()->getAllModels();
$size = SizeBUS::getInstance()->getAllModels();
$id = $_GET['id'];
$product = ProductBUS::getInstance()->getModelById($id);
$sizeItemsProduct = SizeItemsBUS::getInstance()->searchModel($product->getId(), ['product_id']);
if (isLogin()) {
    $userModel = $_SESSION['user'];
}
?>

<div id="header">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail | <?php echo $product->getName() ?> </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/css/singleproduct.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php layouts("header") ?>
    <script>
        $(".hover").mouseleave(
            function () {
                $(this).removeClass("hover");
            }
        );

        $(".active").mouseleave(
            function () {
                $(this).removeClass("active");
            }
        );

        $(document).ready(function () {
            $('.squish-in').click(function () {
                $('.squish-in').css('color', ''); // Remove the color from all buttons
                $(this).css('color', 'black'); // Add the color to the clicked button
            });
        });
    </script>
</div>

<body>
    <div class="singleproduct">
        <button id="closepitem">
            <a href="?module=indexphp&action=product">
                <i class="fa-solid fa-xmark"></i>
            </a>
        </button>
        <hr>
        <h2>Chi Tiết Sản Phẩm</h2>
        <hr>
        <div class="pitem">
            <figure class="pimg">
                <img src="<?php $product->getImage() ?>" alt="">
                <figcaption>
                    <h3>Information</h3>
                    <p>
                        <?php
                        echo $product->getDescription();
                        ?>
                    </p>
                </figcaption><i class="ion-ios-personadd-outline"></i>
            </figure>
            <div class="productcontent">
                <div class="productname">
                    <h2> <span><?php echo $product->getName() ?></span></h2>
                </div>
                <div class="price">
                    <?php echo $product->getPrice() ?> <sup> đ</sup>
                </div>
                <div class="des">
                    <fieldset>
                        <?php
                        echo $product->getDescription();
                        ?>
                    </fieldset>
                </div>
                <div class="psize">
                    Size :
                    <?php
                    $check = 0;
                    foreach ($sizeItemsProduct as $s) {
                        if ($s->getQuantity() > 0) {
                            echo '<div class="button-container"><button class="squish-in">' . $s->getSizeId() . '</button></div>';
                            $check = 1;
                        }
                    }
                    if ($check == 0) {
                        echo 'Sản phẩm tạm thời hết hàng';
                    }
                    ?>
                </div>
                <div class="quantity">
                    <label for="pquantity">Quantity :</label>
                    <input type="number" name="pquantity" id="pquantity" placeholder="1" min="1">
                </div>
                <?php
                if ($check == 0) {
                    //Hide button add to cart:
                    echo '<button class="addtocart" style="display:none;">';
                    //Lock the quantity input:
                    echo '<script>document.getElementById("pquantity").disabled = true;</script>';
                } else {
                    echo '<button class="addtocart">';
                }
                ?>
                <i class="fa-solid fa-cart-shopping"></i>
                <?php
                echo 'Thêm vô giỏ';
                ?>
                </button>
            </div>
        </div>
    </div>
</body>

<div id="footer>
    <?php layouts('footer') ?>
</div>