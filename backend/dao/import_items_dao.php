<?php
require_once 'backend/dao/dao_interface.php';
require_once 'backend/model/import_items_model.php';
require_once 'backend/database/database_connection.php';
class ImportItemsDAO
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ImportItemsDAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $importItemsList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM import_items");
        while ($row = $rs->fetch_assoc()) {
            $importItemsModel = $this->createImportItemsModel($row);
            array_push($importItemsList, $importItemsModel);
        }
        return $importItemsList;
    }
    private function createImportItemsModel($rs)
    {
        $id = $rs['id'];
        $importId = $rs['import_id'];
        $productId = $rs['product_id'];
        $sizeId = $rs['size_id'];
        $quantity = $rs['quantity'];
        $price = $rs['price'];
        return new ImportItemsModel($id, $importId, $productId, $sizeId, $quantity, $price);
    }

    public function getAll(): array
    {
        $importItemsList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM import_items");
        while ($row = $rs->fetch_assoc()) {
            $importItemsModel = $this->createImportItemsModel($row);
            array_push($importItemsList, $importItemsModel);
        }
        return $importItemsList;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM import_items WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createImportItemsModel($row);
        } else {
            return null;
        }
    }

    public function insert($importItemsModel): int
    {
        $query = "INSERT INTO import_items (import_id, product_id, size_id, quantity, price) VALUES (?, ?, ?, ?, ?)";
        $args = [$importItemsModel->getImportId(), $importItemsModel->getProductId(), $importItemsModel->getSizeId(), $importItemsModel->getQuantity(), $importItemsModel->getPrice()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($importItemsModel): int
    {
        $query = "UPDATE import_items SET import_id = ?, product_id = ?, size_id = ?, quantity = ?, price = ? WHERE id = ?";
        $args = [$importItemsModel->getImportId(), $importItemsModel->getProductId(), $importItemsModel->getSizeId(), $importItemsModel->getQuantity(), $importItemsModel->getPrice(), $importItemsModel->getId()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM import_items WHERE id = ?";
        $args = [$id];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function deleteByImportId($id): int
    {
        $query = "DELETE FROM import_items WHERE id = ?";
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
            $query = "SELECT * FROM import_items WHERE CONCAT(id, import_id, product_id, size_id, quantity, price) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM import_items WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, import_id, product_id, size_id, quantity, price FROM import_items WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $importItemsList = [];
        while ($row = $rs->fetch_assoc()) {
            $importItemsModel = $this->createImportItemsModel($row);
            array_push($importItemsList, $importItemsModel);
        }

        if (count($importItemsList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $importItemsList;
    }
}
