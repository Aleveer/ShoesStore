<?php
require_once 'backend/interfaces/dao_interface.php';
require_once 'backend/entities/review_model.php';
require_once 'backend/utilities/db_connection.php';

class ReviewDAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ReviewDAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $reviewList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM reviews");
        while ($row = $rs->fetch_assoc()) {
            $reviewModel = $this->createReviewModel($row);
            array_push($reviewList, $reviewModel);
        }
        return $reviewList;
    }

    private function createReviewModel($rs)
    {
        $id = $rs['id'];
        $productId = $rs['product_id'];
        $userId = $rs['user_id'];
        $content = $rs['content'];
        $rating = $rs['rating'];
        return new ReviewModel($id, $userId, $productId, $content, $rating);
    }

    public function getAll(): array
    {
        $reviewList = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM reviews");
        while ($row = $rs->fetch_assoc()) {
            $reviewModel = $this->createReviewModel($row);
            array_push($reviewList, $reviewModel);
        }
        return $reviewList;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM reviews WHERE id = ?";
        $args = [$id];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $row = $rs->fetch_assoc();
        if ($row) {
            return $this->createReviewModel($row);
        } else {
            return null;
        }
    }

    public function insert($data): int
    {
        $query = "INSERT INTO reviews (user_id, product_id, content, rating) VALUES (?, ?, ?, ?)";
        $args = [$data->getUserId(), $data->getProductId(), $data->getContent(), $data->getRating()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function update($data): int
    {
        $query = "UPDATE reviews SET user_id = ?, product_id = ?, content = ?, rating = ? WHERE id = ?";
        $args = [$data->getUserId(), $data->getProductId(), $data->getContent(), $data->getRating(), $data->getId()];
        return DatabaseConnection::executeUpdate($query, $args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM reviews WHERE id = ?";
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
            $query = "SELECT * FROM reviews WHERE CONCAT(id, product_id, user_id, rating, content) LIKE ?";
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM reviews WHERE $column LIKE ?";
        } else {
            $query = "SELECT * FROM reviews WHERE CONCAT(" . implode(", ", $columnNames) . ") LIKE ?";
        }

        $args = ["%" . $condition . "%"];
        $rs = DatabaseConnection::executeQuery($query, $args);
        $reviewList = [];
        while ($row = $rs->fetch_assoc()) {
            $reviewModel = $this->createReviewModel($row);
            array_push($reviewList, $reviewModel);
        }
        if (count($reviewList) === 0) {
            throw new Exception("No records found for the given condition: " . $condition);
        }

        return $reviewList;
    }
}
