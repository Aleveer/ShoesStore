<?php
namespace backend\models;

class ChatbotConversationModel
{
    private $id, $userId, $sessionToken, $createdAt, $updatedAt, $isActive;

    public function __construct($id, $userId, $sessionToken, $createdAt, $updatedAt, $isActive)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->sessionToken = $sessionToken;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->isActive = $isActive;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getSessionToken()
    {
        return $this->sessionToken;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}