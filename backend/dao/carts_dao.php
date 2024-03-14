<?php
class CartsDAO implements DAOInterface
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CartsDAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $cartsList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM carts");
        while ($row = $rs->fetch_assoc()) {
            $cartsModel = $this->createCartsModel($row);
            array_push($cartsList, $cartsModel);
        }
        return $cartsList;
    }
    private function createCartsModel($rs)
    {
        $id = $rs['id'];
        $userId = $rs['user_id'];
        $productId = $rs['product_id'];
        $quantity = $rs['quantity'];
        $sizeId = $rs['size_id'];
        return new CartsModel($id, $userId, $productId, $quantity, $sizeId);
    }
    public function getAll(): array
    {
        $cartsList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM carts");
        while ($row = $rs->fetch_assoc()) {
            $cartsModel = $this->createCartsModel($row);
            array_push($cartsList, $cartsModel);
        }
        return $cartsList;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM carts WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createCartsModel($row);
        } else {
            return null;
        }
    }

    public function insert($cartsModel): int
    {
        $query = "INSERT INTO carts (user_id, product_id, quantity, size_id) VALUES (?, ?, ?, ?)";
        $args = [$cartsModel->getUserId(), $cartsModel->getProductId(), $cartsModel->getQuantity(), $cartsModel->getSizeId()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($cartsModel): int
    {
        $query = "UPDATE carts SET user_id = ?, product_id = ?, quantity = ?, size_id = ? WHERE id = ?";
        $args = [$cartsModel->getUserId(), $cartsModel->getProductId(), $cartsModel->getQuantity(), $cartsModel->getSizeId(), $cartsModel->getId()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM carts WHERE id = ?";
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
            $query = "SELECT * FROM carts WHERE CONCAT(id, user_id, product_id, quantity, size_id) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM carts WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, user_id, product_id, quantity, size_id FROM carts WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $cartsList = [];
        while ($row = $rs->fetch_assoc()) {
            $cartsModel = $this->createCartsModel($row);
            array_push($cartsList, $cartsModel);
        }

        if (count($cartsList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $cartsList;
    }
}