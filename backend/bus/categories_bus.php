<?php
require_once(__DIR__ . "/../dao/categories_dao.php");
require_once(__DIR__ . "/../interfaces/bus_interface.php");
require_once(__DIR__ . "/../models/categories_model.php");

class CategoriesBUS implements BUSInterface
{
    private $categoriesList = array();
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CategoriesBUS();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->refreshData();
    }

    public function getAllModels(): array
    {
        return $this->categoriesList;
    }

    public function refreshData(): void
    {
        $this->categoriesList = CategoriesDAO::getInstance()->getAll();
    }

    public function getModelById(int $id)
    {
        foreach ($this->categoriesList as $categories) {
            if ($categories->getId() == $id) {
                return $categories;
            }
        }
        return null;
    }

    public function addModel($categoriesModel): int
    {
        $this->validateModel($categoriesModel);
        $result = CategoriesDAO::getInstance()->insert($categoriesModel);
        $this->refreshData();
        return $result;
    }

    public function updateModel($categoriesModel): int
    {
        $this->validateModel($categoriesModel);
        $result = CategoriesDAO::getInstance()->update($categoriesModel);
        $this->refreshData();
        return $result;
    }

    public function deleteModel($categoriesModel): int
    {
        $result = CategoriesDAO::getInstance()->delete($categoriesModel);
        $this->refreshData();
        return $result;
    }

    public function validateModel($categoriesModel)
    {
        if (
            empty($categoriesModel->getName()) ||
            $categoriesModel->getName() == null
        ) {
            throw new InvalidArgumentException("Please fill in all fields");
        }
    }

    public function getModelByName($name)
    {
        foreach ($this->categoriesList as $categories) {
            if ($categories->getName() == $name) {
                return $categories;
            }
        }
        return null;
    }

    public function searchModel(string $value, array $columns)
    {
        return CategoriesDAO::getInstance()->search($value, $columns);
    }
}
