<?php
require_once 'backend/interfaces/dao_interface.php';
require_once 'backend/entities/user_model.php';
require_once 'backend/utilities/db_connection.php';

class UserDAO implements DAOInterface
{
    private static $instance;
    public function readDatabase(): array
    {
        $userList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM users");
        while ($row = $rs->fetch_assoc()) {
            $userModel = $this->createUserModel($row);
            array_push($userList, $userModel);
        }
        return $userList;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UserDAO();
        }
        return self::$instance;
    }

    private function createUserModel($rs)
    {
        $id = $rs['id'];
        $username = $rs['username'];
        $password = $rs['password'];
        $email = $rs['email'];
        $name = $rs['name'];
        $phone = $rs['phone'];
        $gender = $rs['gender'];
        $image = $rs['image'];
        $roleId = $rs['role_id'];
        $address = $rs['address'];
        $status = strtoupper($rs['status']);
        return new UserModel($id, $username, $password, $email, $name, $phone, $gender, $image, $roleId, $status, $address);
    }

    public function getAll(): array
    {
        $userList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM users");
        while ($row = $rs->fetch_assoc()) {
            $userModel = $this->createUserModel($row);
            array_push($userList, $userModel);
        }
        return $userList;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createUserModel($row);
        } else {
            return null;
        }
    }

    public function insert($data): int
    {
        $user = $data;
        $insertSql = "INSERT INTO users (username, password, email, name, phone, gender, image, role_id, address, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $args = [
            $user->getUsername(),
            $user->getPassword(),
            $user->getEmail(),
            $user->getName(),
            $user->getPhone(),
            $user->getGender(),
            $user->getImage(),
            $user->getRoleId(),
            $user->getAddress(),
            strtoupper($user->getStatus())
        ];
        return DatabaseConnection::executeUpdate($insertSql, $args);
    }

    public function update($data): int
    {
        $user = $data;
        $updateSql = "UPDATE users SET username = ?, password = ?, email = ?, name = ?, phone = ?, gender = ?, image = ?, role_id = ?, address = ?, status = ? WHERE id = ?";
        $args = [
            $user->getUsername(),
            $user->getPassword(),
            $user->getEmail(),
            $user->getName(),
            $user->getPhone(),
            $user->getGender(),
            $user->getImage(),
            $user->getRoleId(),
            $user->getAddress(),
            strtoupper($user->getStatus()),
            $user->getId()
        ];
        return DatabaseConnection::executeUpdate($updateSql, $args);
    }

    public function delete($id): int
    {
        $deleteSql = "DELETE FROM users WHERE id = ?";
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
            $query = "SELECT * FROM users WHERE CONCAT(id, username, password, status, name, email, phone, created_at, updated_at, role) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM users WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, username, password, email, image, name, phone, address, gender, role_id, status, created_at, updated_at FROM users WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $userList = [];
        while ($row = $rs->fetch_assoc()) {
            $userModel = $this->createUserModel($row);
            array_push($userList, $userModel);
        }

        if (count($userList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $userList;
    }
}
?>