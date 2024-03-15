<?php
require_once(__DIR__ . "/../dao/coupons_dao.php");
require_once(__DIR__ . "/../backend/models/coupons_model.php");
require_once(__DIR__ . "/../backend/bus/BUSInterface.php");

class CouponsBUS implements BUSInterface
{
    private $couponsList = array();
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CouponsBUS();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->refreshData();
    }

    public function getAllModels(): array
    {
        return $this->couponsList;
    }

    public function refreshData(): void
    {
        $this->couponsList = CouponsDAO::getInstance()->getAll();
    }

    public function getModelById(int $id)
    {
        foreach ($this->couponsList as $coupons) {
            if ($coupons->getId() == $id) {
                return $coupons;
            }
        }
        return null;
    }

    public function addModel($couponsModel): int
    {
        $this->validateModel($couponsModel);
        $result = CouponsDAO::getInstance()->insert($couponsModel);
        $this->refreshData();
        return $result;
    }

    public function updateModel($couponsModel): int
    {
        $this->validateModel($couponsModel);
        $result = CouponsDAO::getInstance()->update($couponsModel);
        $this->refreshData();
        return $result;
    }

    public function deleteModel($couponsModel): int
    {
        $result = CouponsDAO::getInstance()->delete($couponsModel);
        $this->refreshData();
        return $result;
    }

    public function validateModel($couponsModel)
    {
        if (
            empty($couponsModel->getCode()) ||
            empty($couponsModel->getDiscount()) ||
            empty($couponsModel->getExpirationDate()) ||
            $couponsModel->getCode() == null ||
            $couponsModel->getDiscount() == null ||
            $couponsModel->getExpirationDate() == null
        ) {
            throw new Exception("Invalid coupons model");
        }
    }

    public function searchModel(string $value, array $columns)
    {
        return CouponsDAO::getInstance()->search($value, $columns);
    }

    public function applyDiscount($couponsModel, $orderTotal): float
    {
        $discount = $couponsModel->getPercent();
        return $orderTotal - ($orderTotal * $discount / 100);
    }
}
