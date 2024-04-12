<?php
use backend\bus\CustomerBUS;
use backend\bus\ProductBUS;
use backend\bus\CartsBUS;
use backend\bus\UserBUS;
use backend\bus\TokenLoginBUS;
use backend\models\CustomerModel;
use backend\models\OrderItemsModel;
use backend\models\OrdersModel;
use backend\services\session;
use backend\bus\SizeItemsBUS;
use backend\bus\SizeBUS;
use backend\bus\OrdersBUS;
use backend\bus\OrderItemsBUS;
use backend\bus\CouponsBUS;

requireLogin();
CartsBUS::getInstance()->refreshData();
$token = session::getInstance()->getSession('tokenLogin');
$tokenModel = TokenLoginBUS::getInstance()->getModelByToken($token);
$userModel = UserBUS::getInstance()->getModelById($tokenModel->getUserId());
$cartListFromUser = CartsBUS::getInstance()->getModelByUserId($userModel->getId());

if (count($cartListFromUser) == 0) {
    echo '<script>';
    echo 'alert("Giỏ hàng của bạn đang trống!")';
    echo '</script>';
    echo '<script>';
    echo 'window.location.href = "?module=cartsection&action=cart"';
    echo '</script>';
    die();
}

if ($userModel->getRoleId() == 1 || $userModel->getRoleId() == 2 || $userModel->getRoleId() == 3) {
    echo '<script>';
    echo 'alert("Bạn không có quyền truy cập vào trang này!")';
    echo '</script>';
    echo '<script>';
    echo 'window.location.href = "?module=indexphp&action=product"';
    echo '</script>';
    die();
}
?>

<div id="header">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php layouts("header") ?>
</div>

<body>
    <div class="order-confirm">
        <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/cart_handler.js"></script>
        <h2>Order Confirm</h2>
        <form class="row g-1 method=" POST">
            <h4>Customer Info</h4>
            <div class="col-4">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="inputNameId" name="inputName"
                    value="<?php echo $userModel->getName(); ?>">
            </div>
            <div class="col-3">
                <label for="inputText" class="form-label">Phone Number</label>
                <input type="text" class="form-control form-control-sm" id="inputPhoneNumberId" name="inputPhoneNumber"
                    value="<?php echo $userModel->getPhone(); ?>">
            </div>
            <div class="col-5">
                <label for="inputText" class="form-label">Discount</label>
                <input type="text" name="discount-code" class="form-control form-control-sm" id="inputDiscountId"
                    name="inputDiscount">
            </div>
            <div class="col-6">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control form-control-sm" id="inputAddressId" name="inputAddress" placeholder="1234 Main St"
                    name="inputAddress" value="<?php echo $userModel->getAddress(); ?>">
            </div>
            <div class="col-2">
                <label for="inputPayment" class="form-label">Payment Method</label>
                <select id="inputPayment" class="form-select form-select-sm">
                    <option selected>Cash</option>
                    <option>ATM</option>
                    <option>Credit Card</option>
                </select>
            </div>

            <h4 class="pt-3">Product List</h4>
            <div id="order-confirm-product">
                <table class="table table-striped col-12 align-middle table-borderless text-center table-secondary">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2" class="text-start">Product</th>
                            <th scope="col">Size</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody id="productList">
                        <?php
                        foreach ($cartListFromUser as $cartModel) {
                            $productModel = ProductBUS::getInstance()->getModelById($cartModel->getProductId());
                            if (!$productModel) {
                                error_log('Failed to get product model for ID: ' . $cartModel->getProductId());
                                continue; // Skip this iteration and move to the next cartId
                            }
                            $sizeModel = SizeBUS::getInstance()->getModelById($cartModel->getSizeId());
                            if (!$sizeModel) {
                                error_log('Failed to get size model for ID: ' . $cartModel->getSizeId());
                                continue; // Skip this iteration and move to the next cartId
                            }
                            echo '<tr>';
                            echo '<td class="col-1"><img src="' . $productModel->getImage() . '" alt="" class="cart-item-img"></td>';
                            echo '<td class="col-4 cart-item-name text-start">' . $productModel->getName() . '</td>';
                            echo '<td class="col-1 cart-item-size">' . $cartModel->getSizeId() . '</td>';
                            echo '<td class="col-2 cart-item-price">' . $productModel->getPrice() . '</td>';
                            echo '<td class="col-1 cart-item-quantity">' . $cartModel->getQuantity() . '</td>';
                            echo '<td class="col-2 cart-item-total">' . $productModel->getPrice() * $cartModel->getQuantity() . '</td>';
                            echo '</tr>';
                        }
                        ?>
            </div>
            </td>
            </tr>
            </tbody>
            </table>
    </div>
    <form action="?module=cartsection&action=cart" method="POST">
        <div class="btn-group ">
            <input type="button" id="btnBack" value="Back"
                onclick="window.location.href='?module=cartsection&action=cart'">
            <p id="totalPrice"> </p>
            <input type="submit" name="submitButton" id="order-confirm-submit" value="Submit">
        </div>
    </form>
    <?php
    //button to submit the order :
    if (isPost()) {
        if (isset($_POST['submitButton'])) {
            $filterAll = filter();
            $orderModel = new OrdersModel(null, null, null, null, null);
            $orderModel->setCustomerId($userModel->getId());
            $customerModel = CustomerBUS::getInstance()->getModelById($userModel->getId());

            if ($customerModel == null) {
                $customerModel = new CustomerModel(null, null, null, null);
                $customerModel->setId($userModel->getId());
                $customerModel->setName($userModel->getName());
                $customerModel->setPhone($userModel->getPhone());
                $customerModel->setEmail($userModel->getEmail());
                CustomerBUS::getInstance()->addModel($customerModel);
                CustomerBUS::getInstance()->refreshData();
            } else if ($customerModel != null) {
                //Check for any changes in the customer id on html:
                $inputName = $filterAll['inputName'];
                $inputPhoneNumber = $filterAll['inputPhoneNumber'];
                $inputAddress = $filterAll['inputAddress'];
                $customerModel->setName($inputName);
                $customerModel->setPhone($inputPhoneNumber);
                $userModel->setAddress($inputAddress);
                CustomerBUS::getInstance()->updateModel($customerModel);
                CustomerBUS::getInstance()->refreshData();
            }
            $orderModel->setCustomerId($customerModel->getId());
            $orderModel->setUserId($userModel->getId());

            //Get current time:
            $currentTime = date('Y-m-d H:i:s');

            //Check for discount:
            $discountCode = isset($filterAll['discount-code']);
            if ($discountCode != null) {
                //Check if the discount code is valid:
                $discountModel = CouponsBUS::getInstance()->getModelByCode($discountCode);
                //Check if the discount code is expired:
                if ($discountModel->getExpiredDate() < $currentTime) {
                    echo '<script>';
                    echo 'alert("Mã giảm giá đã hết hạn!")';
                    echo '</script>';
                    die();
                }

                //Check if the discount code is valid:
                if ($discountModel == null || trim($discountCode) == "") {
                    echo '<script>';
                    echo 'alert("Mã giảm giá không hợp lệ!")';
                    echo '</script>';
                    die();
                }

                //Check if the discount code has remaining quantity = 0
                if ($discountModel->getRemainingQuantity() == 0) {
                    echo '<script>';
                    echo 'alert("Mã giảm giá đã hết lượt sử dụng!")';
                    echo '</script>';
                    die();
                }

                //If valid, apply the discount to the total price, getDiscount is percentage:
                $totalPrice = $totalPrice - ($totalPrice * $discountModel->getDiscount() / 100);
                echo '<script>';
                echo 'alert("Đã áp dụng mã giảm giá!")';
                echo '</script>';
                echo '<script>';
                echo '$.post("?module=cartsection&action=order", { discount: ' . $discountModel->getDiscount() . ' }, function(discountedPrice) {';
                echo 'updateTotalPrice(discountedPrice);';
                echo '});';
                echo '</script>';
            }

            //Update the coupon remaining quantity:
            $discountModel->setRemainingQuantity($discountModel->getRemainingQuantity() - 1);
            CouponsBUS::getInstance()->updateModel($discountModel);
            CouponsBUS::getInstance()->refreshData();

            $orderModel->setOrderDate($currentTime);
            $orderModel->setTotalAmount($totalPrice);

            OrdersBUS::getInstance()->addModel($orderModel);
            OrdersBUS::getInstance()->refreshData();
            //Create order items:
            foreach ($cartListFromUser as $cartModel) {
                $orderItemModel = new OrderItemsModel(null, null, null, null, null, null);
                $orderItemModel->setOrderId($orderModel->getId());
                $orderItemModel->setProductId($cartModel->getProductId());
                $orderItemModel->setSizeId($cartModel->getSizeId());
                $orderItemModel->setQuantity($cartModel->getQuantity());
                $orderItemModel->setPrice(ProductBUS::getInstance()->getModelById($cartModel->getProductId())->getPrice() * $cartModel->getQuantity());
                OrderItemsBUS::getInstance()->addModel($orderItemModel);
            }

            CartsBUS::getInstance()->refreshData();
            echo '<script>';
            echo 'alert("Đặt hàng thành công!")';
            echo '</script>';
            //When everything is successful, update the quantity in product, check for sizesItem as well:
            foreach ($cartListFromUser as $cartModel) {
                $sizeItemProduct = SizeItemsBUS::getInstance()->getModelBySizeIdAndProductId($cartModel->getSizeId(), $cartModel->getProductId());
                $sizeItemProduct->setQuantity($sizeItemProduct->getQuantity() - $cartModel->getQuantity());
                SizeItemsBUS::getInstance()->updateModel($sizeItemProduct);
                SizeItemsBUS::getInstance()->refreshData();
            }
            echo '<script>';
            echo 'window.location.href = "?module=indexphp&action=product"';
            echo '</script>';
        }
    }
    ?>
    </div>
    <script src="<?php echo _WEB_HOST_TEMPLATE ?>/js/order_processing.js"></script>
    </div>
</body>

<div id="footer">
    <?php layouts("footer") ?>
</div>