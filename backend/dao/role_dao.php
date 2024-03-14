<?php
require_once 'backend/interfaces/dao_interface.php';
require_once 'backend/entities/role_model.php';
require_once 'backend/utilities/db_connection.php';

class RoleDAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new RoleDAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $roleList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM roles");
        while ($row = $rs->fetch_assoc()) {
            $roleModel = $this->createRoleModel($row);
            array_push($roleList, $roleModel);
        }
        return $roleList;
    }

    private function createRoleModel($rs)
    {
        $id = $rs['id'];
        $name = $rs['name'];
        return new RoleModel($id, $name);
    }

    public function getAll(): array
    {
        $roleList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM roles");
        while ($row = $rs->fetch_assoc()) {
            $roleModel = $this->createRoleModel($row);
            array_push($roleList, $roleModel);
        }
        return $roleList;
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM roles WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createRoleModel($row);
        } else {
            return null;
        }
    }

    public function insert($role): int
    {
        $insertSql = "INSERT INTO roles (name) VALUES (?)";
        $args = [$role->getName()];
        return DatabaseConnection::executeUpdate($insertSql, $args);
    }

    public function update($role): int
    {
        $updateSql = "UPDATE roles SET name = ? WHERE id = ?";
        $args = [$role->getName(), $role->getId()];
        return DatabaseConnection::executeUpdate($updateSql, $args);
    }

    public function delete(int $id): int
    {
        $deleteSql = "DELETE FROM roles WHERE id = ?";
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
            $query = "SELECT * FROM roles WHERE CONCAT(id, name) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM roles WHERE $column LIKE ?";
        } else {
            $query = "SELECT * FROM roles WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $roleList = [];
        while ($row = $rs->fetch_assoc()) {
            $roleModel = $this->createRoleModel($row);
            array_push($roleList, $roleModel);
        }

        if (count($roleList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $roleList;
    }
}