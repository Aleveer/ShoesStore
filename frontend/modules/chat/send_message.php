<?php
use backend\bus\ChatbotConversationBUS;
use backend\bus\ChatbotMessageBUS;
use backend\models\ChatbotConversationModel;
use backend\models\ChatbotMessageModel;
use backend\bus\TokenLoginBUS;
use backend\services\session;

require_once(__DIR__ . '/../../../backend/services/DeepSeekService.php');
require_once(__DIR__ . '/../../../backend/bus/chatbotconversation_bus.php');
require_once(__DIR__ . '/../../../backend/bus/chatbotmessage_bus.php');
require_once(__DIR__ . '/../../../backend/models/chatbotconversation_model.php');
require_once(__DIR__ . '/../../../backend/models/chatbotmessage_model.php');

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
debugLog('Login status check', [
    'is_logged_in' => $loginStatus ? 'yes' : 'no'
]);

if (!$loginStatus) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Please login to use the chat']);
    exit;
}

// Get user information from session
$tokenLogin = session::getInstance()->getSession('tokenLogin');
$userTokenModel = TokenLoginBUS::getInstance()->getModelByToken($tokenLogin);
$userId = $userTokenModel ? $userTokenModel->getUserId() : 0;

debugLog('User session details', [
    'token_login' => $tokenLogin ? 'exists' : 'null',
    'user_id' => $userId
]);



// Get API key from environment variable
$apiKey = $_ENV['OPENROUTER_API_KEY'] ?? null;
if (!$apiKey) {
    debugLog('ERROR: API key not found in environment variables');
    echo json_encode(['success' => false, 'message' => 'Chat service configuration error']);
    exit;
}

// Initialize the DeepSeek service with API key from environment
$deepSeek = new DeepSeekService($apiKey);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    debugLog('Received chat request', [
        'POST_data' => $_POST,
        'User_IP' => $_SERVER['REMOTE_ADDR'],
        'User_Agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
    ]);

    $message = $_POST['message'] ?? '';

    if (empty($message)) {
        debugLog('Empty message received');
        echo json_encode(['success' => false, 'message' => 'Message cannot be empty']);
        exit;
    }

    try {
        // Use the user ID we extracted from session
        debugLog('User info for chat', [
            'user_id' => $userId
        ]);

        if (!$userId) {
            debugLog('Invalid user session - no user_id found');
            echo json_encode(['success' => false, 'message' => 'Invalid user session']);
            exit;
        }

        $conversationBus = ChatbotConversationBUS::getInstance();
        $messageBus = ChatbotMessageBUS::getInstance();

        // Get or create conversation
        $conversation = $conversationBus->getActiveConversationByUserId($userId);
        if (!$conversation) {
            debugLog('Creating new conversation for user: ' . $userId);
            $conversation = $conversationBus->startNewConversation($userId);
        }
        $conversationId = $conversation->getId();

        debugLog('Using conversation ID: ' . $conversationId);

        // Create a new message model for user message
        $userMessage = new ChatbotMessageModel(
            null,
            $conversationId,
            'user',
            $message,
            date("Y-m-d H:i:s")
        );
        $messageBus->addModel($userMessage);

        // Get conversation history
        $history = $messageBus->getMessagesByConversationId($conversationId);
        $formattedHistory = array_map(function ($msg) {
            return [
                'role' => $msg->getRole(),
                'content' => $msg->getContent()
            ];
        }, $history);

        debugLog('Sending message to DeepSeek API', [
            'message' => $message,
            'history_count' => count($formattedHistory)
        ]);

        // Send message to DeepSeek
        $response = $deepSeek->sendMessage($message, $formattedHistory);

        debugLog('DeepSeek API response', $response);

        if ($response['success']) {
            try {
                // Create a new message model for bot response
                $botMessage = new ChatbotMessageModel(
                    null,
                    $conversationId,
                    'assistant',
                    $response['message'],
                    date("Y-m-d H:i:s")
                );
                $messageBus->addModel($botMessage);

                debugLog('Successfully saved bot response');

                echo json_encode([
                    'success' => true,
                    'message' => $response['message']
                ]);
            } catch (Exception $e) {
                debugLog("Error saving bot message: " . $e->getMessage());
                debugLog("Stack trace: " . $e->getTraceAsString());
                echo json_encode([
                    'success' => false,
                    'message' => 'The AI responded but we encountered an error saving the message.',
                    'debug' => [
                        'error' => $e->getMessage(),
                        'type' => get_class($e)
                    ]
                ]);
            }
        } else {
            debugLog("DeepSeek API error: " . ($response['error'] ?? 'Unknown error'));
            debugLog("Full response: " . print_r($response, true));
            echo json_encode([
                'success' => false,
                'message' => $response['message'] ?? 'Sorry, I could not process your message at this time.',
                'debug' => [
                    'error' => $response['error'] ?? 'Unknown error',
                    'details' => $response['details'] ?? null
                ]
            ]);
        }
    } catch (Exception $e) {
        debugLog("Unexpected error in chat processing: " . $e->getMessage());
        debugLog("Stack trace: " . $e->getTraceAsString());
        echo json_encode([
            'success' => false,
            'message' => 'An unexpected error occurred while processing your message.',
            'debug' => [
                'error' => $e->getMessage(),
                'type' => get_class($e)
            ]
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}