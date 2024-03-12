<?php
require_once 'backend/interfaces/dao_interface.php';
require_once 'backend/entities/role_permission_model.php';
require_once 'backend/utilities/db_connection.php';

class RolePermissionDAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new RolePermissionDAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $rolePermissionList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM role_permissions");
        while ($row = $rs->fetch_assoc()) {
            $rolePermissionModel = $this->createRolePermissionModel($row);
            array_push($rolePermissionList, $rolePermissionModel);
        }
        return $rolePermissionList;
    }

    private function createRolePermissionModel($rs)
    {
        $id = $rs['id'];
        $roleId = $rs['role_id'];
        $permissionId = $rs['permission_id'];
        return new RolePermissionsModel($id, $roleId, $permissionId);
    }

    public function getAll(): array
    {
        $rolePermissionList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM role_permissions");
        while ($row = $rs->fetch_assoc()) {
            $rolePermissionModel = $this->createRolePermissionModel($row);
            array_push($rolePermissionList, $rolePermissionModel);
        }
        return $rolePermissionList;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM role_permissions WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createRolePermissionModel($row);
        } else {
            return null;
        }
    }

    public function insert($data): int
    {
        $rolePermission = $data;
        $insertSql = "INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)";
        $args = [
            $rolePermission->getRoleId(),
            $rolePermission->getPermissionId()
        ];
        return DatabaseConnection::executeUpdate($insertSql, $args);
    }

    public function update($data): int
    {
        $rolePermission = $data;
        $updateSql = "UPDATE role_permissions SET role_id = ?, permission_id = ? WHERE id = ?";
        $args = [
            $rolePermission->getRoleId(),
            $rolePermission->getPermissionId(),
            $rolePermission->getId()
        ];
        return DatabaseConnection::executeUpdate($updateSql, $args);
    }

    public function delete($id): int
    {
        $deleteSql = "DELETE FROM role_permissions WHERE id = ?";
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
            $query = "SELECT * FROM role_permissions WHERE CONCAT(id, role_id, permission_id) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM role_permissions WHERE $column LIKE ?";
        } else {
            $query = "SELECT * FROM role_permissions WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $rolePermissionList = [];
        while ($row = $rs->fetch_assoc()) {
            $rolePermissionModel = $this->createRolePermissionModel($row);
            array_push($rolePermissionList, $rolePermissionModel);
        }

        if (count($rolePermissionList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $rolePermissionList;
    }
}
