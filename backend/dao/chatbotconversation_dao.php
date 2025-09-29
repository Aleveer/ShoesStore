<?php
namespace backend\dao;

use backend\interfaces\DAOInterface;
use backend\models\ChatbotConversationModel;
use backend\services\DatabaseConnection;

class ChatbotConversationDAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ChatbotConversationDAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $conversations = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM chatbot_conversations");
        while ($row = $rs->fetch_assoc()) {
            $conversation = $this->createConversationModel($row);
            array_push($conversations, $conversation);
        }
        return $conversations;
    }

    private function createConversationModel($rs)
    {
        return new ChatbotConversationModel(
            $rs['id'],
            $rs['user_id'],
            $rs['session_token'],
            $rs['created_at'],
            $rs['updated_at'],
            $rs['is_active']
        );
    }

    public function getAll(): array
    {
        return $this->readDatabase();
    }

    public function getById($id)
    {
        $rs = DatabaseConnection::executeQuery("SELECT * FROM chatbot_conversations WHERE id = ?", $id);
        if ($row = $rs->fetch_assoc()) {
            return $this->createConversationModel($row);
        }
        return null;
    }

    public function getActiveByUserId($userId)
    {
        $rs = DatabaseConnection::executeQuery("SELECT * FROM chatbot_conversations WHERE user_id = ? AND is_active = 1", $userId);
        if ($row = $rs->fetch_assoc()) {
            return $this->createConversationModel($row);
        }
        return null;
    }

    public function insert($data): int
    {
        $query = "INSERT INTO chatbot_conversations (user_id, session_token, created_at, updated_at, is_active) VALUES (?, ?, ?, ?, ?)";
        $args = [
            $data->getUserId(),
            $data->getSessionToken(),
            $data->getCreatedAt(),
            $data->getUpdatedAt(),
            $data->getIsActive()
        ];
        return DatabaseConnection::executeUpdate($query, ...$args);
    }

    public function update($data): int
    {
        $query = "UPDATE chatbot_conversations SET is_active = ?, updated_at = ? WHERE id = ?";
        $args = [$data->getIsActive(), $data->getUpdatedAt(), $data->getId()];
        return DatabaseConnection::executeUpdate($query, ...$args);
    }

    public function delete(int $id): int
    {
        $query = "DELETE FROM chatbot_conversations WHERE id = ?";
        return DatabaseConnection::executeUpdate($query, $id);
    }

    public function deactivateAllForUser($userId): int
    {
        $query = "UPDATE chatbot_conversations SET is_active = 0 WHERE user_id = ?";
        $result = DatabaseConnection::executeUpdate($query, $userId);
        return $result ?? 0; // Return 0 if result is null
    }

    public function search(string $condition, array $columnNames): array
    {
        throw new \Exception("Method not supported");
    }
}