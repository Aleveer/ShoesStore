<?php
namespace backend\dao;

use backend\interfaces\DAOInterface;
use backend\models\ChatbotMessageModel;
use backend\services\DatabaseConnection;

class ChatbotMessageDAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ChatbotMessageDAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $messages = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM chatbot_messages");
        while ($row = $rs->fetch_assoc()) {
            $message = $this->createMessageModel($row);
            array_push($messages, $message);
        }
        return $messages;
    }

    private function createMessageModel($rs)
    {
        return new ChatbotMessageModel(
            $rs['id'],
            $rs['conversation_id'],
            $rs['role'],
            $rs['content'],
            $rs['created_at']
        );
    }

    public function getAll(): array
    {
        return $this->readDatabase();
    }

    public function getById($id)
    {
        $rs = DatabaseConnection::executeQuery("SELECT * FROM chatbot_messages WHERE id = ?", $id);
        if ($row = $rs->fetch_assoc()) {
            return $this->createMessageModel($row);
        }
        return null;
    }

    public function getByConversationId($conversationId)
    {
        $messages = [];
        $rs = DatabaseConnection::executeQuery("SELECT * FROM chatbot_messages WHERE conversation_id = ? ORDER BY created_at ASC", $conversationId);
        while ($row = $rs->fetch_assoc()) {
            $message = $this->createMessageModel($row);
            array_push($messages, $message);
        }
        return $messages;
    }

    public function insert($data): int
    {
        $query = "INSERT INTO chatbot_messages (conversation_id, role, content, created_at) VALUES (?, ?, ?, ?)";
        $args = [
            $data->getConversationId(),
            $data->getRole(),
            $data->getContent(),
            $data->getCreatedAt()
        ];
        return DatabaseConnection::executeUpdate($query, ...$args);
    }

    public function update($data): int
    {
        // Messages typically don't need to be updated
        return 0;
    }

    public function delete(int $id): int
    {
        $query = "DELETE FROM chatbot_messages WHERE id = ?";
        return DatabaseConnection::executeUpdate($query, $id);
    }

    public function deleteByConversationId($conversationId): int
    {
        $query = "DELETE FROM chatbot_messages WHERE conversation_id = ?";
        return DatabaseConnection::executeUpdate($query, $conversationId);
    }

    public function search(string $condition, array $columnNames): array
    {
        throw new \Exception("Method not supported");
    }
}