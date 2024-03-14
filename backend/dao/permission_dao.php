<?php
require_once 'backend/entities/permission_model.php';
require_once 'backend/utilities/db_connection.php';
require_once 'backend/dao/dao_interface.php';

class PermissionDAO implements DAOInterface
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PermissionDAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $permissionList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM permissions");
        while ($row = $rs->fetch_assoc()) {
            $permissionModel = $this->createPermissionModel($row);
            array_push($permissionList, $permissionModel);
        }
        return $permissionList;
    }
    private function createPermissionModel($rs)
    {
        $id = $rs['id'];
        $name = $rs['name'];
        return new PermissionsModel($id, $name);
    }
    public function getAll(): array
    {
        $permissionList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM permissions");
        while ($row = $rs->fetch_assoc()) {
            $permissionModel = $this->createPermissionModel($row);
            array_push($permissionList, $permissionModel);
        }
        return $permissionList;
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM permissions WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createPermissionModel($row);
        } else {
            return null;
        }
    }

    public function insert($permission): int
    {
        $query = "INSERT INTO permissions (name) VALUES (?)";
        $args = [$permission->getName()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($permission): int
    {
        $query = "UPDATE permissions SET name = ? WHERE id = ?";
        $args = [$permission->getName(), $permission->getId()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete(int $id): int
    {
        $query = "DELETE FROM permissions WHERE id = ?";
        $args = [$id];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function search(string $condition, array $columnNames = null): array
    {
        if (empty(trim($condition))) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }

        $query = "";
        if ($columnNames === null || count($columnNames) === 0) {
            $query = "SELECT * FROM permissions WHERE CONCAT(id, name) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM permissions WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, name FROM permissions WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $permissionList = [];
        while ($row = $rs->fetch_assoc()) {
            $permissionModel = $this->createPermissionModel($row);
            array_push($permissionList, $permissionModel);
        }

        if (count($permissionList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $permissionList;
    }
}
