<?php
require_once 'backend/interfaces/dao_interface.php';
require_once 'backend/entities/size_item_model.php';
require_once 'backend/utilities/db_connection.php';

class SizeItemsDAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SizeItemsDAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $sizeItemList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM size_items");
        while ($row = $rs->fetch_assoc()) {
            $sizeItemModel = $this->createSizeItemModel($row);
            array_push($sizeItemList, $sizeItemModel);
        }
        return $sizeItemList;
    }

    private function createSizeItemModel($rs)
    {
        $id = $rs['id'];
        $productId = $rs['product_id'];
        $sizeId = $rs['size_id'];
        $quantity = $rs['quantity'];
        return new SizeItemsModel($id, $productId, $sizeId, $quantity);
    }

    public function getAll(): array
    {
        $sizeItemList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM size_items");
        while ($row = $rs->fetch_assoc()) {
            $sizeItemModel = $this->createSizeItemModel($row);
            array_push($sizeItemList, $sizeItemModel);
        }
        return $sizeItemList;
    }

    public function getById(int $id)
    {
        $query = "SELECT * FROM size_items WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createSizeItemModel($row);
        } else {
            return null;
        }
    }

    public function insert($sizeItem): int
    {
        $insertSql = "INSERT INTO size_items (product_id, size_id, quantity) VALUES (?, ?, ?)";
        $args = [
            $sizeItem->getProductId(),
            $sizeItem->getSizeId(),
            $sizeItem->getQuantity(),
        ];
        return DatabaseConnection::executeUpdate($insertSql, $args);
    }

    public function update($sizeItem): int
    {
        $updateSql = "UPDATE size_items SET product_id = ?, size_id = ? WHERE quantity = ?";
        $args = [
            $sizeItem->getProductId(),
            $sizeItem->getSizeId(),
            $sizeItem->getQuantity(),
        ];
        return DatabaseConnection::executeUpdate($updateSql, $args);
    }

    public function delete(int $id): int
    {
        $deleteSql = "DELETE FROM size_items WHERE id = ?";
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
            $query = "SELECT * FROM size_items WHERE CONCAT(id, product_id, size_id, quantity) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM size_items WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, product_id, size_id, quantity FROM size_items WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $sizeItemList = [];
        while ($row = $rs->fetch_assoc()) {
            $sizeItemModel = $this->createSizeItemModel($row);
            array_push($sizeItemList, $sizeItemModel);
        }

        if (count($sizeItemList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $sizeItemList;
    }
}
