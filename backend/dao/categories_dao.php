<?php
class CategoriesDAO implements DAOInterface
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CategoriesDAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $categoriesList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM categories");
        while ($row = $rs->fetch_assoc()) {
            $categoriesModel = $this->createCategoriesModel($row);
            array_push($categoriesList, $categoriesModel);
        }
        return $categoriesList;
    }
    private function createCategoriesModel($rs)
    {
        $id = $rs['id'];
        $name = $rs['name'];
        return new CategoriesModel($id, $name);
    }
    public function getAll(): array
    {
        $categoriesList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM categories");
        while ($row = $rs->fetch_assoc()) {
            $categoriesModel = $this->createCategoriesModel($row);
            array_push($categoriesList, $categoriesModel);
        }
        return $categoriesList;
    }
    public function getById($id)
    {
        $query = "SELECT * FROM categories WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createCategoriesModel($row);
        } else {
            return null;
        }
    }
    public function insert($categoriesModel): int
    {
        $query = "INSERT INTO categories (name) VALUES (?)";
        $args = [$categoriesModel->getName()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($categoriesModel): int
    {
        $query = "UPDATE categories SET name = ? WHERE id = ?";
        $args = [$categoriesModel->getName(), $categoriesModel->getId()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM categories WHERE id = ?";
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
            $query = "SELECT * FROM categories WHERE CONCAT(id, name) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM categories WHERE $column LIKE ?";
        } else {
            $query = "SELECT id, name FROM categories WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $categoriesList = [];
        while ($row = $rs->fetch_assoc()) {
            $categoriesModel = $this->createCategoriesModel($row);
            array_push($categoriesList, $categoriesModel);
        }

        if (count($categoriesList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $categoriesList;
    }
}