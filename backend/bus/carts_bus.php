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
        $result = CartsDAO::getInstance()->insert($cartsModel);
        $this->refreshData();
        return $result;
    }

    public function updateModel($cartsModel): int
    {
        $this->validateModel($cartsModel);
        $result = CartsDAO::getInstance()->update($cartsModel);
        $this->refreshData();
        return $result;
    }

    public function deleteModel(int $id): int
    {
        $result = CartsDAO::getInstance()->delete($id);
        $this->refreshData();
        return $result;
    }

    public function searchModel(string $value, array $columns)
    {
        return CartsDAO::getInstance()->search($value, $columns);
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
