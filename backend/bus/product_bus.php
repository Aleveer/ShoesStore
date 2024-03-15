<?php
require_once(__DIR__ . "/../dao/product_dao.php");
require_once(__DIR__ . "/../interfaces/bus_interface.php");
require_once(__DIR__ . "/../models/product_model.php");

class ProductBUS implements BUSInterface
{
    private $productList = array();
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ProductBUS();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->productList = ProductDAO::getInstance()->getAll();
    }

    public function getAllModels(): array
    {
        return $this->productList;
    }

    public function refreshData(): void
    {
        $this->productList = ProductDAO::getInstance()->getAll();
    }

    public function getModelById(int $id)
    {
        foreach ($this->productList as $product) {
            if ($product->getId() == $id) {
                return $product;
            }
        }
        return null;
    }

    public function addModel($productModel): int
    {
        if (
            empty($productModel->getName()) ||
            empty($productModel->getCategoryId()) ||
            empty($productModel->getPrice()) ||
            empty($productModel->getDescription()) ||
            empty($productModel->getImage()) ||
            empty($productModel->getGender() ||
                $productModel->getName() == null ||
                $productModel->getCategoryId() == null ||
                $productModel->getPrice() == null ||
                $productModel->getDescription() == null ||
                $productModel->getImage() == null ||
                $productModel->getGender() == null)
        ) {
            throw new InvalidArgumentException("Please fill in all fields");
        }

        if ($productModel->getPrice() < 0) {
            throw new InvalidArgumentException("Price must be greater than 0");
        }

        if ($productModel->getCategoryId() < 0) {
            throw new InvalidArgumentException("Category ID must be greater than 0");
        }

        $newProduct = ProductDAO::getInstance()->insert($productModel);
        if ($newProduct) {
            $this->productList[] = $productModel;
            $this->refreshData();
            return true;
        }
        return false;
    }

    public function updateModel($model)
    {
        $result = ProductDAO::getInstance()->update($model);
        if ($result) {
            $index = array_search($model, $this->productList);
            $this->productList[$index] = $model;
            $this->refreshData();
            return true;
        }
        return false;
    }

    public function deleteModel(int $id)
    {
        $result = ProductDAO::getInstance()->delete($id);
        if ($result) {
            $index = array_search($id, array_column($this->productList, 'id'));
            unset($this->productList[$index]);
            $this->refreshData();
            return true;
        }
        return false;
    }

    public function searchModel(string $condition, $columnNames): array
    {
        return ProductDAO::getInstance()->search($condition, $columnNames);
    }

    public function searchBetweenPrice($min, $max)
    {
        $result = [];
        foreach ($this->productList as $product) {
            if ($product->getPrice() >= $min && $product->getPrice() <= $max) {
                $result[] = $product;
            }
        }
        return $result;
    }

    public function getRandomRecommendProducts()
    {
        $result = [];
        $randomKeys = array_rand($this->productList, 3);
        foreach ($randomKeys as $key) {
            $result[] = $this->productList[$key];
        }
        return $result;
    }
}
