<?php
use backend\bus\ProductBUS;
use backend\bus\CategoriesBUS;

class DeepSeekService
{
    private const API_ENDPOINT = 'https://openrouter.ai/api/v1/chat/completions';
    private $apiKey;
    private $productList;

    public function __construct($apiKey)
    {
        // Set error log path
        ini_set('error_log', __DIR__ . '/../../logs/chat_error.log');
        $this->apiKey = $apiKey;

        if (empty($this->apiKey)) {
            error_log("DeepSeekService: No API key provided");
            throw new Exception("API key is required");
        }

        // Load products and categories from database
        try {
            $this->productList = ProductBUS::getInstance()->getActiveProductOnly();
            error_log("[DeepSeek] Loaded " . count($this->productList) . " products from database");

            // Log first few products for verification
            if (!empty($this->productList)) {
                $sampleProducts = array_slice($this->productList, 0, 3);
                foreach ($sampleProducts as $i => $product) {
                    error_log("[DeepSeek] Sample Product " . ($i + 1) . ": " . $product->getName() . " - $" . $product->getPrice());
                }
            }
        } catch (Exception $e) {
            error_log("[DeepSeek] Error loading products: " . $e->getMessage());
            error_log("[DeepSeek] Stack trace: " . $e->getTraceAsString());
            $this->productList = [];
        }
    }

    private function formatProductCatalog()
    {
        error_log("[DeepSeek] Formatting product catalog - Product count: " . count($this->productList));

        if (empty($this->productList)) {
            error_log("[DeepSeek] No products found in productList");
            return "Currently no products available in our store.";
        }

        try {
            // Get categories for better product information
            $categories = CategoriesBUS::getInstance()->getAllModels();
            $categoryLookup = [];
            foreach ($categories as $category) {
                $categoryLookup[$category->getId()] = $category->getName();
            }
            error_log("[DeepSeek] Loaded " . count($categories) . " categories from database");

            $productCatalog = "=== OUR STORE INVENTORY (FROM DATABASE) ===\n";
            $productCount = 0;

            foreach ($this->productList as $product) {
                $genderText = ($product->getGender() == 0) ? 'Men' : 'Women';
                $categoryName = $categoryLookup[$product->getCategoryId()] ?? 'General';

                $productLine = "• " . $product->getName() .
                    " (" . $categoryName . " - " . $genderText . ") - \$" . number_format($product->getPrice()) .
                    " - " . $product->getDescription() . "\n";

                $productCatalog .= $productLine;
                $productCount++;
            }

            $productCatalog .= "=== END OF INVENTORY (" . $productCount . " products) ===\n";

            error_log("[DeepSeek] Generated product catalog with " . $productCount . " products");
            error_log("[DeepSeek] Product catalog preview: " . substr($productCatalog, 0, 500));

            return $productCatalog;
        } catch (Exception $e) {
            error_log("[DeepSeek] Error formatting product catalog: " . $e->getMessage());
            error_log("[DeepSeek] Stack trace: " . $e->getTraceAsString());
            return "Product catalog temporarily unavailable.";
        }
    }

    public function sendMessage($message, $conversationHistory = [])
    {
        try {
            error_log("[DeepSeek] Starting new message request for: " . substr($message, 0, 100));

            // Validate input
            if (empty(trim($message))) {
                return ['success' => false, 'message' => 'Message cannot be empty'];
            }

            // Get formatted product catalog
            $productCatalog = $this->formatProductCatalog();

            // Create system message with instructions and product catalog
            $systemPrompt = "You are a shoe store assistant AI. You can ONLY recommend products that exist in the current store inventory provided below. Under NO circumstances should you suggest products that are not in this exact list.\n\n" . $productCatalog . "\n\nSTRICT RULES:\n- If someone asks for running shoes, ONLY recommend from the 'Running Shoes' category in the inventory above\n- If someone asks for basketball shoes, ONLY recommend from the 'Basketball Shoes' category in the inventory above\n- If someone asks for tennis shoes, ONLY recommend from the 'Tennis' category in the inventory above\n- If someone asks for walking shoes, ONLY recommend from the 'Walking Shoes' category in the inventory above\n- If someone asks for trail running shoes, ONLY recommend from the 'Trail Running Shoes' category in the inventory above\n- You CANNOT recommend Nike Air Zoom Pegasus 37, Brooks Ghost 13, Asics Gel-Nimbus 23, or any other shoes not listed in the inventory\n- Always copy the EXACT product names, prices, and descriptions from the inventory list above\n- Use this format: • [Exact Product Name from Inventory] ([Category] - [Gender]) - \$[Exact Price] - [Exact Description]\n\nRemember: You can ONLY recommend shoes that are listed in the inventory between '=== OUR STORE INVENTORY ===' markers above.";

            error_log("[DeepSeek] System prompt length: " . strlen($systemPrompt));
            $messages = [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ]
            ];

            // Add conversation history (limit to last 10 messages to avoid token limits)
            $recentHistory = array_slice($conversationHistory, -10);
            foreach ($recentHistory as $msg) {
                if (isset($msg['role']) && isset($msg['content'])) {
                    $messages[] = [
                        'role' => $msg['role'],
                        'content' => $msg['content']
                    ];
                }
            }

            // Add current message
            $messages[] = [
                'role' => 'user',
                'content' => trim($message)
            ];

            $data = [
                'model' => 'openai/gpt-3.5-turbo',
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 1000,
                'stream' => false
            ];

            error_log("[DeepSeek] Request payload: " . json_encode($data, JSON_PRETTY_PRINT));

            $ch = curl_init(self::API_ENDPOINT);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $this->apiKey,
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'HTTP-Referer: http://localhost/frontend/index.php',
                    'X-Title: Shoe Store Chat'
                ],
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 3
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                error_log("cURL Error: " . $curlError);
                return [
                    'success' => false,
                    'message' => 'Connection error occurred. Please try again.',
                    'error' => 'cURL Error: ' . $curlError
                ];
            }

            error_log("[DeepSeek] HTTP Response Code: " . $httpCode);
            error_log("[DeepSeek] Raw Response: " . substr($response, 0, 500));

            if ($httpCode === 200) {
                $jsonResponse = json_decode($response, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    error_log("JSON decode error: " . json_last_error_msg());
                    return [
                        'success' => false,
                        'message' => 'Invalid response format from API',
                        'error' => 'JSON decode error: ' . json_last_error_msg()
                    ];
                }

                if (!isset($jsonResponse['choices'][0]['message']['content'])) {
                    error_log("Unexpected API response structure: " . print_r($jsonResponse, true));
                    return [
                        'success' => false,
                        'message' => 'Unexpected API response structure',
                        'error' => 'Missing expected response fields'
                    ];
                }

                $assistantMessage = trim($jsonResponse['choices'][0]['message']['content']);
                error_log("[DeepSeek] Original AI response: " . $assistantMessage);

                // Validate that the response only contains products from our database
                $validatedMessage = $this->validateResponse($assistantMessage);
                error_log("[DeepSeek] Validated response: " . $validatedMessage);

                return ['success' => true, 'message' => $validatedMessage];
            }

            // Handle error responses
            $errorData = json_decode($response, true);
            $errorMessage = $this->getErrorMessage($httpCode, $errorData);

            error_log("API Error (HTTP $httpCode): " . $errorMessage);
            error_log("Full error response: " . print_r($errorData, true));

            return [
                'success' => false,
                'message' => $errorMessage,
                'error' => $errorData['error']['message'] ?? $errorMessage
            ];

        } catch (Exception $e) {
            error_log("Exception in sendMessage: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());

            return [
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again.',
                'error' => $e->getMessage()
            ];
        }
    }

    private function validateResponse($response)
    {
        if (empty($this->productList)) {
            return $response;
        }

        // Create a list of valid product names from our database
        $validProductNames = [];
        foreach ($this->productList as $product) {
            $validProductNames[] = $product->getName();
        }

        error_log("[DeepSeek] Valid product names: " . implode(', ', array_slice($validProductNames, 0, 5)) . '...');

        // Check if the response contains products not in our database
        $problematicProducts = [
            'Nike Air Zoom Pegasus 37',
            'Brooks Ghost 13',
            'Asics Gel-Nimbus 23',
            'Adidas Ultraboost',
            'Hoka Bondi 7'
        ];

        $hasInvalidProducts = false;
        foreach ($problematicProducts as $invalidProduct) {
            if (stripos($response, $invalidProduct) !== false) {
                $hasInvalidProducts = true;
                error_log("[DeepSeek] Found invalid product in response: " . $invalidProduct);
                break;
            }
        }

        if ($hasInvalidProducts) {
            // Generate a proper response using only our database products
            $runningShoes = [];
            foreach ($this->productList as $product) {
                try {
                    $categories = CategoriesBUS::getInstance()->getAllModels();
                    $categoryLookup = [];
                    foreach ($categories as $category) {
                        $categoryLookup[$category->getId()] = $category->getName();
                    }

                    $categoryName = $categoryLookup[$product->getCategoryId()] ?? 'General';
                    if ($categoryName === 'Running Shoes') {
                        $genderText = ($product->getGender() == 0) ? 'Men' : 'Women';
                        $runningShoes[] = "• " . $product->getName() .
                            " (" . $categoryName . " - " . $genderText . ") - \$" . number_format($product->getPrice()) .
                            " - " . $product->getDescription();
                    }
                } catch (Exception $e) {
                    error_log("[DeepSeek] Error in validation: " . $e->getMessage());
                }
            }

            if (!empty($runningShoes)) {
                $correctedResponse = "Here are the running shoes available in our store:\n\n" . implode("\n", $runningShoes);
                error_log("[DeepSeek] Generated corrected response with " . count($runningShoes) . " products");
                return $correctedResponse;
            }
        }

        return $response;
    }

    private function getErrorMessage($httpCode, $errorData)
    {
        return match ($httpCode) {
            400 => 'Invalid request - ' . ($errorData['error']['message'] ?? 'Bad request'),
            401 => 'Unauthorized - Please check API key configuration',
            402 => 'Payment required - Please check your API subscription',
            403 => 'Access forbidden - ' . ($errorData['error']['message'] ?? 'Access denied'),
            404 => 'API endpoint not found',
            429 => 'Too many requests - Please try again in a moment',
            500, 502, 503, 504 => 'Service temporarily unavailable - Please try again later',
            default => 'Unexpected response code: ' . $httpCode
        };
    }
}