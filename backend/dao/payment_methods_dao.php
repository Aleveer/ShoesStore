<?php
class PaymentMethodsDAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PaymentMethodsDAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $paymentMethodsList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM payment_methods");
        while ($row = $rs->fetch_assoc()) {
            $paymentMethodsModel = $this->createPaymentMethodsModel($row);
            array_push($paymentMethodsList, $paymentMethodsModel);
        }
        return $paymentMethodsList;
    }

    private function createPaymentMethodsModel($rs)
    {
        $id = $rs['id'];
        $name = $rs['name'];
        return new PaymentMethodModel($id, $name);
    }

    public function getAll(): array
    {
        $paymentMethodsList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM payment_methods");
        while ($row = $rs->fetch_assoc()) {
            $paymentMethodsModel = $this->createPaymentMethodsModel($row);
            array_push($paymentMethodsList, $paymentMethodsModel);
        }
        return $paymentMethodsList;
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM payment_methods WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createPaymentMethodsModel($row);
        } else {
            return null;
        }
    }

    public function insert($paymentMethodModel): int
    {
        $query = "INSERT INTO payment_methods (name) VALUES (?)";
        $args = [$paymentMethodModel->getName()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($paymentMethodModel): int
    {
        $query = "UPDATE payment_methods SET name = ? WHERE id = ?";
        $args = [$paymentMethodModel->getName(), $paymentMethodModel->getId()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete(int $id): int
    {
        $query = "DELETE FROM payment_methods WHERE id = ?";
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
            $query = "SELECT * FROM payment_methods WHERE CONCAT(id, name) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM payment_methods WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, name FROM payment_methods WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $paymentMethodsList = [];
        while ($row = $rs->fetch_assoc()) {
            $paymentMethodsModel = $this->createPaymentMethodsModel($row);
            array_push($paymentMethodsList, $paymentMethodsModel);
        }

        if (count($paymentMethodsList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $paymentMethodsList;
    }
}
