<?php
namespace backend\bus;

use backend\interfaces\BUSInterface;
use backend\dao\ChatbotConversationDAO;
use backend\models\ChatbotConversationModel;

class ChatbotConversationBUS implements BUSInterface
{
    private $conversationList = array();
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ChatbotConversationBUS();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->refreshData();
    }

    public function getAllModels(): array
    {
        return $this->conversationList;
    }

    public function refreshData(): void
    {
        $this->conversationList = ChatbotConversationDAO::getInstance()->getAll();
    }

    public function getModelById($id)
    {
        return ChatbotConversationDAO::getInstance()->getById($id);
    }

    public function getActiveConversationByUserId($userId)
    {
        return ChatbotConversationDAO::getInstance()->getActiveByUserId($userId);
    }

    public function startNewConversation($userId)
    {
        // Deactivate all existing conversations for this user
        ChatbotConversationDAO::getInstance()->deactivateAllForUser($userId);

        // Create a new conversation
        $sessionToken = sha1(uniqid() . time());
        $now = date("Y-m-d H:i:s");

        $conversation = new ChatbotConversationModel(
            null,
            $userId,
            $sessionToken,
            $now,
            $now,
            1 // Active
        );

        ChatbotConversationDAO::getInstance()->insert($conversation);
        $this->refreshData();

        return $this->getActiveConversationByUserId($userId);
    }

    public function deactivateAllUserConversations($userId): int
    {
        return ChatbotConversationDAO::getInstance()->deactivateAllForUser($userId);
    }

    public function addModel($model)
    {
        ChatbotConversationDAO::getInstance()->insert($model);
        $this->refreshData();
    }

    public function updateModel($model)
    {
        ChatbotConversationDAO::getInstance()->update($model);
        $this->refreshData();
    }

    public function deleteModel(int $id)
    {
        ChatbotConversationDAO::getInstance()->delete($id);
        $this->refreshData();
    }

    public function searchModel(string $value, array $columns)
    {
        return ChatbotConversationDAO::getInstance()->search($value, $columns);
    }
}