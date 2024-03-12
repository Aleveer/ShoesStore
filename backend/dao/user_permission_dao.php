<?php
require_once 'backend/interfaces/dao_interface.php';
require_once 'backend/models/user_permission_model.php';
require_once 'backend/utilities/db_connection.php';

class UserPermissionDAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UserPermissionDAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $permissionList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM user_permissions");
        while ($row = $rs->fetch_assoc()) {
            $permissionModel = $this->createUserPermissionModel($row);
            array_push($permissionList, $permissionModel);
        }
        return $permissionList;
    }

    private function createUserPermissionModel($rs)
    {
        $id = $rs['id'];
        $permissionId = $rs['permission_id'];
        $userId = $rs['user_id'];
        $status = $rs['status'];
        return new UserPermissionModel($id, $permissionId, $userId, $status);
    }

    public function getAll(): array
    {
        $permissionList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM user_permissions");
        while ($row = $rs->fetch_assoc()) {
            $permissionModel = $this->createUserPermissionModel($row);
            array_push($permissionList, $permissionModel);
        }
        return $permissionList;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM user_permissions WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        if ($row = $rs->fetch_assoc()) {
            return $this->createUserPermissionModel($row);
        }
        return null;
    }

    public function insert($userPermission): int
    {
        $query = "INSERT INTO user_permissions (permission_id, user_id, status) VALUES (?, ?, ?)";
        $args = [
            $userPermission->getPermissionId(),
            $userPermission->getUserId(),
            strtoupper($userPermission->getStatus())
        ];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($userPermission): int
    {
        $query = "UPDATE user_permissions SET permission_id = ?, user_id = ?, status = ? WHERE id = ?";
        $args = [
            $userPermission->getPermissionId(),
            $userPermission->getUserId(),
            $userPermission->getStatus(),
            $userPermission->getId()
        ];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM user_permissions WHERE id = ?";
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

            $query =
                "SELECT * FROM user_permissions WHERE concat(id, permission_id, user_id, status) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM user_permissions WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, permission_id, user_id, status FROM user_permissions WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $userList = [];
        while ($row = $rs->fetch_assoc()) {
            $userModel = $this->createUserPermissionModel($row);
            array_push($userList, $userModel);
        }

        if (count($userList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $userList;
    }
}
