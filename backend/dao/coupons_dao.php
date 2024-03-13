<?php
require_once "backend/dao/database_connection.php";
require_once "backend/dao/dao_interface.php";
require_once "backend/model/coupons_model.php";

class CouponsDAO implements DAOInterface
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CouponsDAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $couponsList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM coupons");
        while ($row = $rs->fetch_assoc()) {
            $couponsModel = $this->createCouponsModel($row);
            array_push($couponsList, $couponsModel);
        }
        return $couponsList;
    }
    private function createCouponsModel($rs)
    {
        $id = $rs['id'];
        $code = $rs['code'];
        $quantity = $rs['quantity'];
        $required = $rs['required'];
        $percent = $rs['percent'];
        $expired = $rs['expired'];
        $description = $rs['description'];
        return new CouponsModel($id, $code, $quantity, $required, $percent, $expired, $description);
    }

    public function getAll(): array
    {
        $couponsList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM coupons");
        while ($row = $rs->fetch_assoc()) {
            $couponsModel = $this->createCouponsModel($row);
            array_push($couponsList, $couponsModel);
        }
        return $couponsList;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM coupons WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createCouponsModel($row);
        } else {
            return null;
        }
    }

    public function insert($couponsModel): int
    {
        $query = "INSERT INTO coupons (code, quantity, required, percent, expired, description) VALUES (?, ?, ?, ?, ?, ?)";
        $args = [$couponsModel->getCode(), $couponsModel->getQuantity(), $couponsModel->getRequired(), $couponsModel->getPercent(), $couponsModel->getExpired(), $couponsModel->getDescription()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($couponsModel): int
    {
        $query = "UPDATE coupons SET code = ?, quantity = ?, required = ?, percent = ?, expired = ?, description = ? WHERE id = ?";
        $args = [$couponsModel->getCode(), $couponsModel->getQuantity(), $couponsModel->getRequired(), $couponsModel->getPercent(), $couponsModel->getExpired(), $couponsModel->getDescription(), $couponsModel->getId()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM coupons WHERE id = ?";
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
            $query = "SELECT * FROM coupons WHERE CONCAT(id, code, quantity, required, percent, expired, description) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM coupons WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, code, quantity, required, percent, expired, description FROM coupons WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $couponsList = [];
        while ($row = $rs->fetch_assoc()) {
            $couponsModel = $this->createCouponsModel($row);
            array_push($couponsList, $couponsModel);
        }

        if (count($couponsList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $couponsList;
    }
}
