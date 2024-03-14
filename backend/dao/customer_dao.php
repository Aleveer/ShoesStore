<?php
class CustomerDAO implements DAOInterface
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CustomerDAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $customerList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM customers");
        while ($row = $rs->fetch_assoc()) {
            $customerModel = $this->createCustomerModel($row);
            array_push($customerList, $customerModel);
        }
        return $customerList;
    }
    private function createCustomerModel($rs)
    {
        $id = $rs['id'];
        $name = $rs['name'];
        $email = $rs['email'];
        $phone = $rs['phone'];
        return new CustomerModel($id, $name, $phone, $email);
    }

    public function getAll(): array
    {
        $customerList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM customers");
        while ($row = $rs->fetch_assoc()) {
            $customerModel = $this->createCustomerModel($row);
            array_push($customerList, $customerModel);
        }
        return $customerList;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM customers WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createCustomerModel($row);
        } else {
            return null;
        }
    }

    public function insert($customerModel): int
    {
        $query = "INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)";
        $args = [$customerModel->getName(), $customerModel->getEmail(), $customerModel->getPhone()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($customerModel): int
    {
        $query = "UPDATE customers SET name = ?, email = ?, phone = ? WHERE id = ?";
        $args = [$customerModel->getName(), $customerModel->getEmail(), $customerModel->getPhone(), $customerModel->getId()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM customers WHERE id = ?";
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
            $query = "SELECT * FROM customers WHERE CONCAT(id, name, phone, email) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM customers WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, name, phone, email FROM customers WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $customerList = [];
        while ($row = $rs->fetch_assoc()) {
            $customerModel = $this->createCustomerModel($row);
            array_push($customerList, $customerModel);
        }

        if (count($customerList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $customerList;
    }
}