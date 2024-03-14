<?php
require_once 'backend/interfaces/dao_interface.php';
require_once 'backend/entities/size_model.php';
require_once 'backend/utilities/db_connection.php';

class SizeDAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SizeDAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $sizeList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM sizes");
        while ($row = $rs->fetch_assoc()) {
            $sizeModel = $this->createSizeModel($row);
            array_push($sizeList, $sizeModel);
        }
        return $sizeList;
    }

    private function createSizeModel($rs)
    {
        $id = $rs['id'];
        $name = $rs['name'];
        return new SizeModel($id, $name);
    }

    public function getAll(): array
    {
        $sizeList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM sizes");
        while ($row = $rs->fetch_assoc()) {
            $sizeModel = $this->createSizeModel($row);
            array_push($sizeList, $sizeModel);
        }
        return $sizeList;
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM sizes WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createSizeModel($row);
        } else {
            return null;
        }
    }

    public function insert($data): int
    {
        $size = $data;
        $insertSql = "INSERT INTO sizes (name) VALUES (?)";
        $args = [$size->getName()];
        return DatabaseConnection::executeUpdate($insertSql, $args);
    }

    public function update($data): int
    {
        $size = $data;
        $updateSql = "UPDATE sizes SET name = ? WHERE id = ?";
        $args = [$size->getName(), $size->getId()];
        return DatabaseConnection::executeUpdate($updateSql, $args);
    }

    public function delete(int $id): int
    {
        $deleteSql = "DELETE FROM sizes WHERE id = ?";
        $args = [$id];
        return DatabaseConnection::executeUpdate($deleteSql, $args);
    }

    public function search(string $condition, array $columnNames = null): array
    {
        if (empty(trim($condition))) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }

        $query = "";
        if ($columnNames === null || count($columnNames) === 0) {
            $query = "SELECT * FROM sizes WHERE CONCAT(id, name) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM sizes WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, name FROM sizes WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $sizeList = [];
        while ($row = $rs->fetch_assoc()) {
            $sizeModel = $this->createSizeModel($row);
            array_push($sizeList, $sizeModel);
        }

        if (count($sizeList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $sizeList; 
    }
}
