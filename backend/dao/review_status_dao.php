<?php
require_once 'backend/interfaces/dao_interface.php';
require_once 'backend/entities/review_status_model.php';
require_once 'backend/utilities/db_connection.php';

class ReviewStatusDAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ReviewStatusDAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $statusList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM review_statuses");
        while ($row = $rs->fetch_assoc()) {
            $statusModel = $this->createStatusModel($row);
            array_push($statusList, $statusModel);
        }
        return $statusList;
    }

    private function createStatusModel($rs)
    {
        $id = $rs['id'];
        $productId = $rs['product_id'];
        $status = strtoupper($rs['status']);
        return new ReviewStatusModel($id, $productId, $status);
    }

    public function getAll(): array
    {
        $statusList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM review_statuses");
        while ($row = $rs->fetch_assoc()) {
            $statusModel = $this->createStatusModel($row);
            array_push($statusList, $statusModel);
        }
        return $statusList;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM review_status WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createStatusModel($row);
        } else {
            return null;
        }
    }

    public function insert($data): int
    {
        $status = $data;
        $insertSql = "INSERT INTO review_status (product_id, status) VALUES (?)";
        $args = [$status->getStatus()];
        return DatabaseConnection::executeUpdate($insertSql, $args);
    }

    public function update($data): int
    {
        $status = $data;
        $updateSql = "UPDATE review_status SET product_id = ?, status = ? WHERE id = ?";
        $args = [$status->getProductId(), $status->getStatus(), $status->getId()];
        return DatabaseConnection::executeUpdate($updateSql, $args);
    }

    public function delete($id): int
    {
        $deleteSql = "DELETE FROM review_status WHERE id = ?";
        $args = [$id];
        return DatabaseConnection::executeUpdate($deleteSql, $args);
    }

    public function search($condition, $columnNames = null): array
    {
        if (empty(trim($condition))) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }

        $query = "";
        if ($columnNames === null || count($columnNames) === 0) {
            $query = "SELECT * FROM review_status WHERE CONCAT(id, product_id, status) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM review_status WHERE $column LIKE ?";
        } else {
            $query = "SELECT * FROM review_status WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $statusList = [];
        while ($row = $rs->fetch_assoc()) {
            $statusModel = $this->createStatusModel($row);
            array_push($statusList, $statusModel);
        }

        if (count($statusList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $statusList;
    }
}
