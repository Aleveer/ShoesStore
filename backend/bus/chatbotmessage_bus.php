<?php
namespace backend\bus;

use backend\interfaces\BUSInterface;
use backend\dao\ChatbotMessageDAO;
use backend\models\ChatbotMessageModel;

class ChatbotMessageBUS implements BUSInterface
{
    private $messageList = array();
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ChatbotMessageBUS();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->refreshData();
    }

    public function getAllModels(): array
    {
        return $this->messageList;
    }

    public function refreshData(): void
    {
        $this->messageList = ChatbotMessageDAO::getInstance()->getAll();
    }

    public function getModelById($id)
    {
        return ChatbotMessageDAO::getInstance()->getById($id);
    }

    public function getMessagesByConversationId($conversationId)
    {
        return ChatbotMessageDAO::getInstance()->getByConversationId($conversationId);
    }

    public function addMessage($conversationId, $role, $content)
    {
        $now = date("Y-m-d H:i:s");
        $message = new ChatbotMessageModel(
            null,
            $conversationId,
            $role,
            $content,
            $now
        );

        ChatbotMessageDAO::getInstance()->insert($message);
        $this->refreshData();
    }

    public function deleteConversationMessages($conversationId)
    {
        ChatbotMessageDAO::getInstance()->deleteByConversationId($conversationId);
        $this->refreshData();
    }

    public function addModel($model)
    {
        ChatbotMessageDAO::getInstance()->insert($model);
        $this->refreshData();
    }

    public function updateModel($model)
    {
        ChatbotMessageDAO::getInstance()->update($model);
        $this->refreshData();
    }

    public function deleteModel(int $id)
    {
        ChatbotMessageDAO::getInstance()->delete($id);
        $this->refreshData();
    }

    public function searchModel(string $value, array $columns)
    {
        return ChatbotMessageDAO::getInstance()->search($value, $columns);
    }
}