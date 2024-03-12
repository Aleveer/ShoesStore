<?php
require_once 'backend/entities/product_model.php';
require_once 'backend/utilities/db_connection.php';
require_once 'backend/dao/dao_interface.php';

class ProductDAO implements DAOInterface
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ProductDAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $productList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM products");
        while ($row = $rs->fetch_assoc()) {
            $productModel = $this->createProductModel($row);
            array_push($productList, $productModel);
        }
        return $productList;
    }
    private function createProductModel($rs)
    {
        $id = $rs['id'];
        $name = $rs['name'];
        $categoryId = $rs['category_id'];
        $price = $rs['price'];
        $description = $rs['description'];
        $image = $rs['image'];
        $gender = $rs['gender'];
        return new ProductModel($id, $name, $categoryId, $price, $description, $image, $gender);
    }

    public function getAll(): array
    {
        $productList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM products");
        while ($row = $rs->fetch_assoc()) {
            $productModel = $this->createProductModel($row);
            array_push($productList, $productModel);
        }
        return $productList;
    }
    public function getById($id)
    {
        $query = "SELECT * FROM products WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createProductModel($row);
        } else {
            return null;
        }
    }

    public function insert($data): int
    {
        $query = "INSERT INTO products (name, category_id, price, description, image, gender) VALUES (?, ?, ?, ?, ?, ?)";
        $args = [
            $data['name'],
            $data['category_id'],
            $data['price'],
            $data['description'],
            $data['image'],
            $data['gender']
        ];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($data): int
    {
        $query = "UPDATE products SET name = ?, category_id = ?, price = ?, description = ?, image = ?, gender = ? WHERE id = ?";
        $args = [
            $data['name'],
            $data['category_id'],
            $data['price'],
            $data['description'],
            $data['image'],
            $data['gender'],
            $data['id']
        ];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM products WHERE id = ?";
        $args = [$id];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function search($condition, $columnNames = null): array
    {
        if (empty(trim($condition))) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }

        $query = "";
        if ($columnNames === null || count($columnNames) === 0) {
            $query = "SELECT * FROM products WHERE CONCAT(id, name, category_id, price, description, image, gender) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM products WHERE $column LIKE ?";
        } else {
            $columns = implode(", ", $columnNames);
            $query = "SELECT id, name, category_id, price, description, image, gender FROM products WHERE CONCAT($columns) LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $productList = [];
        while ($row = $rs->fetch_assoc()) {
            $productModel = $this->createProductModel($row);
            array_push($productList, $productModel);
        }

        if (count($productList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $productList;
    }
}
