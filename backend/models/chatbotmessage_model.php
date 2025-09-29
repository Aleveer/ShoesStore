<?php
namespace backend\models;

class ChatbotMessageModel
{
    private $id, $conversationId, $role, $content, $createdAt;

    public function __construct($id, $conversationId, $role, $content, $createdAt)
    {
        $this->id = $id;
        $this->conversationId = $conversationId;
        $this->role = $role;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getConversationId()
    {
        return $this->conversationId;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}