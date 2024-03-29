<?php
require_once(__DIR__ . "/../interfaces/bus_interface.php");
require_once(__DIR__ . "/../dao/size_items_dao.php");
require_once(__DIR__ . "/../models/size_items_model.php");
class SizeItemsBUS implements BUSInterface
{
    private $sizeItemsList = array();
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SizeItemsBUS();
        }
        return self::$instance;
    }
    private function __construct()
    {
        $this->refreshData();
    }
    public function getAllModels(): array
    {
        return $this->sizeItemsList;
    }
    public function refreshData(): void
    {
        $this->sizeItemsList = SizeItemsDAO::getInstance()->getAll();
    }
    public function getModelById(int $id)
    {
        return SizeItemsDAO::getInstance()->getById($id);
    }
    public function addModel($sizeItemsModel): int
    {
        $this->validateModel($sizeItemsModel);
        $result = SizeItemsDAO::getInstance()->insert($sizeItemsModel);
        if ($result) {
            $this->sizeItemsList[] = $sizeItemsModel;
            $this->refreshData();
        }
        return $result;
    }
    public function updateModel($sizeItemsModel): int
    {
        $this->validateModel($sizeItemsModel);
        $result = SizeItemsDAO::getInstance()->update($sizeItemsModel);
        if ($result) {
            $index = array_search($sizeItemsModel, $this->sizeItemsList);
            $this->sizeItemsList[$index] = $sizeItemsModel;
            $this->refreshData();
        }
        return $result;
    }
    public function deleteModel($sizeItemsModel): int
    {
        $result = SizeItemsDAO::getInstance()->delete($sizeItemsModel);
        if ($result) {
            $index = array_search($sizeItemsModel, $this->sizeItemsList);
            unset($this->sizeItemsList[$index]);
            $this->refreshData();
        }
        return $result;
    }

    public function searchModel(string $value, array $columns)
    {
        return SizeItemsDAO::getInstance()->search($value, $columns);
    }

    public function validateModel($sizeItemsModel): void
    {
        if ($sizeItemsModel->getSizeId() == null) {
            throw new Exception("Size ID is required");
        }
        if ($sizeItemsModel->getProductId() == null) {
            throw new Exception("Product ID is required");
        }
        if ($sizeItemsModel->getQuantity() == null) {
            throw new Exception("Quantity is required");
        }
    }

    public function getModelBySizeIdAndProductId($sizeId, $productId)
    {
        foreach ($this->sizeItemsList as $sizeItems) {
            if ($sizeItems->getSizeId() == $sizeId && $sizeItems->getProductId() == $productId) {
                return $sizeItems;
            }
        }
        return null;
    }
}
