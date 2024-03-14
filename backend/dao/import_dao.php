<?php
require_once(__DIR__ . "/../dao/database_connection.php");
require_once(__DIR__ . "/../models/import_model.php");
require_once(__DIR__ . "/../interfaces/dao_interface.php");

class ImportDAO implements DAOInterface
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ImportDAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $importList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM imports");
        while ($row = $rs->fetch_assoc()) {
            $importModel = $this->createImportModel($row);
            array_push($importList, $importModel);
        }
        return $importList;
    }

    private function createImportModel($rs)
    {
        $id = $rs['id'];
        $userId = $rs['user_id'];
        $totalPrice = $rs['total_price'];
        $importDate = $rs['import_date'];
        return new ImportModel($id, $userId, $totalPrice, $importDate);
    }

    public function getAll(): array
    {
        $importList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM imports");
        while ($row = $rs->fetch_assoc()) {
            $importModel = $this->createImportModel($row);
            array_push($importList, $importModel);
        }
        return $importList;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM imports WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createImportModel($row);
        } else {
            return null;
        }
    }

    public function insert($importModel): int
    {
        $query = "INSERT INTO imports (user_id, total_price, import_date) VALUES (?, ?, ?)";
        $args = [$importModel->getUserId(), $importModel->getTotalPrice(), $importModel->getImportDate()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($importModel): int
    {
        $query = "UPDATE imports SET user_id = ?, total_price = ?, import_date = ? WHERE id = ?";
        $args = [$importModel->getUserId(), $importModel->getTotalPrice(), $importModel->getImportDate(), $importModel->getId()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM imports WHERE id = ?";
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
            $query = "SELECT * FROM imports WHERE CONCAT(id, user_id, total_price, import_date) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM imports WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, user_id, total_price, import_date FROM imports WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $importList = [];
        while ($row = $rs->fetch_assoc()) {
            $importModel = $this->createImportModel($row);
            array_push($importList, $importModel);
        }

        if (count($importList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $importList;
    }
}
