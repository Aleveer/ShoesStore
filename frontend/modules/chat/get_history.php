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

// Check login status and log the result
$loginStatus = isLogin();
if (!$loginStatus) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Please login to use the chat']);
    exit;
}

require_once(__DIR__ . '/../../../backend/bus/chatbotconversation_bus.php');
require_once(__DIR__ . '/../../../backend/bus/chatbotmessage_bus.php');
require_once(__DIR__ . '/../../../backend/models/chatbotconversation_model.php');
require_once(__DIR__ . '/../../../backend/models/chatbotmessage_model.php');
require_once(__DIR__ . '/../../../backend/bus/token_login_bus.php');
require_once(__DIR__ . '/../../../backend/services/session.php');

use backend\bus\ChatbotConversationBUS;
use backend\bus\ChatbotMessageBUS;
use backend\models\ChatbotConversationModel;
use backend\models\ChatbotMessageModel;
use backend\bus\TokenLoginBUS;
use backend\services\session;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Get user information from session
        $tokenLogin = session::getInstance()->getSession('tokenLogin');
        $userTokenModel = TokenLoginBUS::getInstance()->getModelByToken($tokenLogin);
        $userId = $userTokenModel ? $userTokenModel->getUserId() : 0;

        debugLog('Getting chat history for user', ['user_id' => $userId]);

        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'Invalid user session']);
            exit;
        }

        $conversationBus = ChatbotConversationBUS::getInstance();
        $messageBus = ChatbotMessageBUS::getInstance();

        // Get active conversation for user
        $conversation = $conversationBus->getActiveConversationByUserId($userId);

        if (!$conversation) {
            debugLog('No active conversation found for user');
            echo json_encode(['success' => true, 'messages' => []]);
            exit;
        }

        $conversationId = $conversation->getId();
        debugLog('Found conversation ID: ' . $conversationId);

        // Get conversation history (last 20 messages)
        $history = $messageBus->getMessagesByConversationId($conversationId);

        // Format messages for frontend
        $formattedMessages = [];
        $messageCount = 0;

        // Get last 20 messages
        $recentHistory = array_slice($history, -20);

        foreach ($recentHistory as $msg) {
            $formattedMessages[] = [
                'role' => $msg->getRole(),
                'content' => $msg->getContent(),
                'created_at' => $msg->getCreatedAt()
            ];
            $messageCount++;
        }

        debugLog('Returning chat history', [
            'conversation_id' => $conversationId,
            'message_count' => $messageCount
        ]);

        echo json_encode([
            'success' => true,
            'messages' => $formattedMessages,
            'conversation_id' => $conversationId
        ]);

    } catch (Exception $e) {
        debugLog("Error getting chat history: " . $e->getMessage());
        debugLog("Stack trace: " . $e->getTraceAsString());
        echo json_encode([
            'success' => false,
            'message' => 'Error loading chat history',
            'error' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}