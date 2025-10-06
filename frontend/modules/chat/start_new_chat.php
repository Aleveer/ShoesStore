<?php
if (!defined('_CODE')) {
    die('Access denied');
}

// Configure error logging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../../logs/chat_error.log');
error_reporting(E_ALL);

// Debug function
function debugLog($message, $data = null)
{
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message";
    if ($data !== null) {
        $logMessage .= "\nData: " . print_r($data, true);
    }
    error_log($logMessage);
}

// Check login status
$loginStatus = isLogin();
if (!$loginStatus) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Please login to use the chat']);
    exit;
}

use backend\bus\ChatbotConversationBUS;
use backend\bus\ChatbotMessageBUS;
use backend\bus\TokenLoginBUS;
use backend\services\session;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get user information from session
        $tokenLogin = session::getInstance()->getSession('tokenLogin');
        $userTokenModel = TokenLoginBUS::getInstance()->getModelByToken($tokenLogin);
        $userId = $userTokenModel ? $userTokenModel->getUserId() : 0;

        debugLog('Starting new chat session for user', ['user_id' => $userId]);

        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'Invalid user session']);
            exit;
        }

        $conversationBus = ChatbotConversationBUS::getInstance();
        $messageBus = ChatbotMessageBUS::getInstance();

        // Get current active conversation and clear its messages
        $conversation = $conversationBus->getActiveConversationByUserId($userId);
        if ($conversation) {
            $conversationId = $conversation->getId();

            // Delete all messages in the current conversation
            $messageBus->deleteConversationMessages($conversationId);

            debugLog('Deleted messages for conversation ID: ' . $conversationId);
        }

        // Deactivate all conversations for this user
        $conversationBus->deactivateAllUserConversations($userId);

        // Start a completely new conversation
        $newConversation = $conversationBus->startNewConversation($userId);

        debugLog('Started new conversation', [
            'conversation_id' => $newConversation->getId(),
            'user_id' => $userId
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'New chat session started successfully',
            'conversation_id' => $newConversation->getId()
        ]);

    } catch (Exception $e) {
        debugLog("Error starting new chat session: " . $e->getMessage());
        debugLog("Stack trace: " . $e->getTraceAsString());
        echo json_encode([
            'success' => false,
            'message' => 'Error starting new chat session',
            'error' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}