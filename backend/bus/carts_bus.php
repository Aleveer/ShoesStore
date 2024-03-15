<?php
require_once(__DIR__ . "/../dao/carts_dao.php");
require_once(__DIR__ . "/../interfaces/bus_interface.php");
require_once(__DIR__ . "/../models/carts_model.php");

class CartsBUS implements BUSInterface
{
    private $cartsList = array();
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CartsBUS();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->refreshData();
    }

    public function getAllModels(): array
    {
        return $this->cartsList;
    }

    public function refreshData(): void
    {
        $this->cartsList = CartsDAO::getInstance()->getAll();
    }

    public function getModelById(int $id)
    {
        foreach ($this->cartsList as $carts) {
            if ($carts->getId() == $id) {
                return $carts;
            }
        }
        return null;
    }

    public function checkDuplicateProduct($userId, $productId, $sizeId)
    {
        foreach ($this->cartsList as $carts) {
            if ($carts->getUserId() == $userId && $carts->getProductId() == $productId && $carts->getSizeId() == $sizeId) {
                return $carts;
            }
        }
        return null;
    }

    public function addModel($cartsModel): int
    {
        $this->validateModel($cartsModel);
        return CartsDAO::getInstance()->insert($cartsModel);
    }

    public function updateModel($cartsModel): int
    {
        $this->validateModel($cartsModel);
        return CartsDAO::getInstance()->update($cartsModel);
    }

    public function deleteModel(int $id): int
    {
        return CartsDAO::getInstance()->delete($id);
    }

    public function deleteModelByUserId(int $userId): int
    {
        foreach ($this->cartsList as $carts) {
            if ($carts->getUserId() == $userId) {
                $this->deleteModel($carts->getId());
            }
        }
        return 1;
    }

    public function searchModel(string $value, array $columns)
    {
        return CartsDAO::getInstance()->search($value, $columns);
    }

    public function getCartByUserId(int $userId)
    {
        $cartList = array();
        foreach ($this->cartsList as $carts) {
            if ($carts->getUserId() == $userId) {
                $cartList[] = $carts;
            }
        }
        return $cartList;
    }

    public function getCartByUserIdAndProductId(int $userId, int $productId)
    {
        foreach ($this->cartsList as $carts) {
            if ($carts->getUserId() == $userId && $carts->getProductId() == $productId) {
                return $carts;
            }
        }
        return null;
    }

    public function getCartByUserIdAndSizeId(int $userId, int $sizeId)
    {
        foreach ($this->cartsList as $carts) {
            if ($carts->getUserId() == $userId && $carts->getSizeId() == $sizeId) {
                return $carts;
            }
        }
        return null;
    }

    public function getCartByUserIdAndProductIdAndSizeId(int $userId, int $productId, int $sizeId)
    {
        foreach ($this->cartsList as $carts) {
            if ($carts->getUserId() == $userId && $carts->getProductId() == $productId && $carts->getSizeId() == $sizeId) {
                return $carts;
            }
        }
        return null;
    }

    public function getCartByUserIdAndProductIdAndSizeIdAndColorId(int $userId, int $productId, int $sizeId, int $colorId)
    {
        foreach ($this->cartsList as $carts) {
            if ($carts->getUserId() == $userId && $carts->getProductId() == $productId && $carts->getSizeId() == $sizeId && $carts->getColorId() == $colorId) {
                return $carts;
            }
        }
        return null;
    }

    private function validateModel($cartsModel): void
    {
        if (
            empty($cartsModel->getUserId()) ||
            empty($cartsModel->getProductId()) ||
            empty($cartsModel->getQuantity()) ||
            $cartsModel->getUserId() == null ||
            $cartsModel->getProductId() == null ||
            $cartsModel->getQuantity() == null
        ) {
            throw new InvalidArgumentException("Please fill in all fields");
        }
    }
}
