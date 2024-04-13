<?php

namespace backend\dao;

use Exception;
use backend\interfaces\DAOInterface;
use InvalidArgumentException;
use backend\models\OrdersModel;
use backend\services\DatabaseConnection;

class OrdersDAO implements DAOInterface
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new OrdersDAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $ordersList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM orders");
        while ($row = $rs->fetch_assoc()) {
            $ordersModel = $this->createOrdersModel($row);
            array_push($ordersList, $ordersModel);
        }
        return $ordersList;
    }
    private function createOrdersModel($rs)
    {
        $id = $rs['id'];
        $userId = $rs['user_id'];
        $orderDate = $rs['order_date'];
        $totalAmount = $rs['total_amount'];
        return new OrdersModel($id, $userId, $orderDate, $totalAmount);
    }

    public function getAll(): array
    {
        $ordersList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM orders");
        while ($row = $rs->fetch_assoc()) {
            $ordersModel = $this->createOrdersModel($row);
            array_push($ordersList, $ordersModel);
        }
        return $ordersList;
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM orders WHERE id = ?";
        $rs = DatabaseConnection::executeQuery($query, $id);
        if ($rs->num_rows > 0) {
            $row = $rs->fetch_assoc();
            if ($row) {
                return $this->createOrdersModel($row);
            }
        }
        return null;
    }

    public function getLastOrderId(): int
    {
        $sql = "SELECT MAX(id) as maxId FROM orders";
        $result = DatabaseConnection::getInstance()->getConnection()->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['maxId'];
        }
        return 0;
    }

    public function insert($ordersModel): int
    {
        $query = "INSERT INTO orders (user_id, order_date, total_amount) VALUES (?, ?, ?)";
        $args = [$ordersModel->getUserId(), $ordersModel->getOrderDate(), $ordersModel->getTotalAmount()];
        return DatabaseConnection::executeUpdate(  $query, ...$args);
    }

    public function update($ordersModel): int
    {
        $query = "UPDATE orders SET user_id = ?, order_date = ?, total_amount = ? WHERE id = ?";
        $args = [$ordersModel->getUserId(), $ordersModel->getOrderDate(), $ordersModel->getTotalAmount(), $ordersModel->getId()];
        return DatabaseConnection::executeUpdate($query, ...$args);
    }
    public function delete(int $id): int
    {
        $query = "DELETE FROM orders WHERE id = ?";
        return DatabaseConnection::executeUpdate($query, $id);
    }

    public function search(string $condition, $columnNames): array
    {
        if (empty($condition)) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }
        $query = "";
        if ($columnNames === null || count($columnNames) === 0) {
            $query = "SELECT * FROM orders WHERE id LIKE ? OR user_id LIKE ? OR order_date LIKE ? OR total_amount LIKE ?";
            $args = array_fill(0, 5, "%" . $condition . "%");
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM orders WHERE $column LIKE ?";
            $args = ["%" . $condition . "%"];
        } else {
            $query = "SELECT * FROM orders WHERE " . implode(" LIKE ? OR ", $columnNames) . " LIKE ?";
            $args = array_fill(0, count($columnNames), "%" . $condition . "%");
        }
        $rs = DatabaseConnection::executeQuery($query, ...$args);
        $ordersList = [];
        while ($row = $rs->fetch_assoc()) {
            $ordersModel = $this->createOrdersModel($row);
            array_push($ordersList, $ordersModel);
        }
        if (count($ordersList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }
        return $ordersList;
    }
}
