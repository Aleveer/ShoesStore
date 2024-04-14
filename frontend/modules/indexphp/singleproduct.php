<?php
use backend\bus\ProductBUS;
use backend\bus\SizeBUS;
use backend\bus\SizeItemsBUS;
use backend\bus\CategoriesBUS;
use backend\bus\TokenLoginBUS;
use backend\bus\UserBUS;
use backend\models\CartsModel;
use backend\services\session;
use backend\bus\CartsBUS;
use backend\enums\StatusEnums;

global $id;
$categoriesList = CategoriesBUS::getInstance()->getAllModels();
$size = SizeBUS::getInstance()->getAllModels();
$id = $_GET['id'];
$product = ProductBUS::getInstance()->getModelById($id);
$sizeItemsProduct = SizeItemsBUS::getInstance()->getModelByProductId($id);
if (isLogin()) {
    $token = session::getInstance()->getSession('tokenLogin');
    $tokenModel = TokenLoginBUS::getInstance()->getModelByToken($token);
    $userModel = UserBUS::getInstance()->getModelById($tokenModel->getUserId());
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
                $('.squish-in').css('color', '');
                $(this).css('color', 'black');
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
                <img src="<?php echo $product->getImage() ?>" alt="">
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
                    Size:
                    <?php
                    $check = 0;
                    foreach ($sizeItemsProduct as $s) {
                        if ($s->getQuantity() > 0) {
                            echo '<div class="button-container"><button id="sizeItemProduct" class="squish-in" name="sizeItem" data-quantity="' . $s->getQuantity() . '">' . $s->getSizeId() . '</button></div>';
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
                    <input type="number" name="pquantity" id="pquantity" placeholder="1" min="1" required>
                </div>
                <?php
                if (isLogin()) {
                    if ($userModel->getRoleId() == 1 || $userModel->getRoleId() == 2 || $userModel->getRoleId() == 3) {
                        //Hide button add to cart:
                        echo '<button class="addtocart" name="addToCart" style="display:none;">';
                        //Lock the quantity input:
                        echo '<script>document.getElementById("pquantity").disabled = true;</script>';
                    }
                }
                if ($check == 0) {
                    //Hide button add to cart:
                    echo '<button class="addtocart" name="addToCart" style="display:none;">';
                    //Lock the quantity input:
                    echo '<script>document.getElementById("pquantity").disabled = true;</script>';
                } else {
                    echo '<button class="addtocart" name="addToCart">';
                }
                ?>
                <i class="fa-solid fa-cart-shopping"> Add+</i>
                </button>
                <?php
                if (!isLogin()) {
                    echo '<script>document.querySelector(".addtocart").addEventListener("click", function() {alert("You have to login in order to add a product to cart!")});</script>';
                    die();
                } else {
                    if (isPost()) {
                        if (isset($_POST['addtocart'])) {
                            if ($userModel->getStatus() === strtolower(StatusEnums::BANNED)) {
                                $data = array(
                                    'status' => 'error',
                                    'message' => 'Your account has been banned. You cannot perform this action'
                                );
                                // Use json_encode to convert the array to a JSON string
                                $jsonData = json_encode($data);
                                // Send the JSON string as the response
                                echo $jsonData;
                                // Stop further script execution
                                die();
                            } else if ($userModel->getStatus() === strtolower(StatusEnums::INACTIVE)) {
                                    //$script = '<script>alert("Tài khoản của bạn chưa được kích hoạt. Vui lòng đăng nhập lại để kích hoạt tài khoản!")</script>';
                                    $data = array(
                                        'status' => 'error',
                                        'message' => 'Your account has not been activated. Please log in again to activate your account'
                                    );
                                    $jsonData = json_encode($data);
                                    echo $jsonData;
                                    $userModel->setStatus(StatusEnums::INACTIVE);
                                    UserBUS::getInstance()->updateModel($userModel);
                                    TokenLoginBUS::getInstance()->deleteModel($tokenModel);
                                    session::getInstance()->removeSession('tokenLogin');
                                    redirect('?module=auth&action=login');
                                    die();
                                } else {
                                    error_log('User status: ' . $userModel->getStatus() . ' - ' . StatusEnums::ACTIVE . ' - ' . $userModel->getStatus() === strtolower(StatusEnums::ACTIVE));
                                }

                            $filterAll = filter();
                            $sizeId = $filterAll['sizeItem'];
                            $quantity = $filterAll['pquantity'];

                            $cartItem = CartsBUS::getInstance()->getModelByUserIdAndProductIdAndSizeId($userModel->getId(), $product->getId(), $sizeId);
                            if ($cartItem != null) {
                                $sizeItems = SizeItemsBUS::getInstance()->searchModel($product->getId(), ['product_id', $sizeId]);
                                foreach ($sizeItems as $sizeItem) {
                                    if ($cartItem->getQuantity() + $quantity > $sizeItem->getQuantity()) {
                                        $data = array(
                                            'status' => 'error',
                                            'message' => 'The quantity of the product in the cart exceeds the remaining quantity of the product'
                                        );
                                        $jsonData = json_encode($data);
                                        die();
                                    } else if ($cartItem->getQuantity() + $quantity <= $sizeItem->getQuantity()) {
                                        // $data = array(
                                        //     'message' => 'Sản phẩm đã có sẵn ở giỏ hàng của bạn, số lượng sản phẩm đã được cập nhật thêm'
                                        // );
                                        // $scrip = '<script>document.querySelector(".addtocart").addEventListener("click", function() {alert(' . json_encode($data['message']) . ')});</script>';
                                        $data = array(
                                            'status' => 'success',
                                            'message' => 'The product is already in your cart, the quantity of the product has been updated'
                                        );
                                        $jsonData = json_encode($data);
                                        $cartItem->setQuantity($cartItem->getQuantity() + $quantity);
                                        CartsBUS::getInstance()->updateModel($cartItem);
                                        CartsBUS::getInstance()->refreshData();
                                        die();
                                    }
                                }
                            } else if ($cartItem == null) {
                                $cart = new CartsModel(null, null, null, null, null);
                                $cart->setUserId($userModel->getId());
                                $cart->setProductId($product->getId());
                                $cart->setSizeId($sizeId);
                                //Check if the quantity is greater than the quantity of the product:
                                $sizeItems = SizeItemsBUS::getInstance()->searchModel($product->getId(), ['product_id', $sizeId]);
                                foreach ($sizeItems as $sizeItem) {
                                    if ($quantity > $sizeItem->getQuantity()) {
                                        $cart->setQuantity($sizeItem->getQuantity());
                                    }
                                }
                                $cart->setQuantity($quantity);
                                CartsBUS::getInstance()->addModel($cart);
                                CartsBUS::getInstance()->refreshData();
                                $data = array(
                                    'status' => 'success',
                                    'message' => 'Add product to cart successfully'
                                );
                                $jsonData = json_encode($data);
                                echo $jsonData;
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
        <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/add_to_cart.js"></script>
    </div>
</body>

<div id="footer>
    <?php layouts('footer') ?>
</div>