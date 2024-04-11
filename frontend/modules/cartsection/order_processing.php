<?php
use backend\bus\ProductBUS;
use backend\bus\CartsBUS;
use backend\bus\UserBUS;
use backend\bus\TokenLoginBUS;
use backend\services\session;
use backend\bus\OrdersBUS;
use backend\bus\OrderItemsBUS;
use backend\bus\CustomerBUS;
use backend\bus\CouponsBUS;
use backend\bus\SizeItemsBUS;
use backend\models\CustomerModel;
use backend\models\OrdersModel;
use backend\models\OrderItemsModel;

$token = session::getInstance()->getSession('tokenLogin');
$tokenModel = TokenLoginBUS::getInstance()->getModelByToken($token);
$userModel = UserBUS::getInstance()->getModelById($tokenModel->getUserId());
$cartListFromUser = CartsBUS::getInstance()->getModelByUserId($userModel->getId());

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
            echo 'updateTotalPrice(' . $discountModel->getDiscount() . ')';
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