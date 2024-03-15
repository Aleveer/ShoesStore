<?php
require_once(__DIR__ . "/../interfaces/bus_interface.php");
require_once(__DIR__ . "/../models/import_items_model.php");
require_once(__DIR__ . "/../dao/import_items_dao.php");

class ImportItemsBUS implements BUSInterface
{
    private $importItemsList = array();
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ImportItemsBUS();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->refreshData();
    }

    public function getAllModels(): array
    {
        return $this->importItemsList;
    }

    public function refreshData(): void
    {
        $this->importItemsList = ImportItemsDAO::getInstance()->getAll();
    }

    public function getModelById(int $id)
    {
        foreach ($this->importItemsList as $importItems) {
            if ($importItems->getId() == $id) {
                return $importItems;
            }
        }
        return null;
    }

    public function addModel($importItemsModel): int
    {
        $this->validateModel($importItemsModel);
        return ImportItemsDAO::getInstance()->insert($importItemsModel);
    }

    public function updateModel($importItemsModel): int
    {
        $this->validateModel($importItemsModel);
        return ImportItemsDAO::getInstance()->update($importItemsModel);
    }

    public function deleteModel($importItemsModel): int
    {
        return ImportItemsDAO::getInstance()->delete($importItemsModel);
    }

    public function validateModel($importItemsModel): void
    {
        if ($importItemsModel->getImportId() == null) {
            throw new Exception("Import ID is required");
        }
        if ($importItemsModel->getProductId() == null) {
            throw new Exception("Product ID is required");
        }
        if ($importItemsModel->getQuantity() == null) {
            throw new Exception("Quantity is required");
        }
        if ($importItemsModel->getPrice() == null) {
            throw new Exception("Price is required");
        }
    }

    public function searchModel(string $value, array $columns)
    {
        return ImportItemsDAO::getInstance()->search($value, $columns);
    }


    public function getModelsByImportId(int $importId): array
    {
        $models = array();
        foreach ($this->importItemsList as $importItems) {
            if ($importItems->getImportId() == $importId) {
                $models[] = $importItems;
            }
        }
        return $models;
    }

    public function getModelsByProductId(int $productId): array
    {
        $models = array();
        foreach ($this->importItemsList as $importItems) {
            if ($importItems->getProductId() == $productId) {
                $models[] = $importItems;
            }
        }
        return $models;
    }
}
