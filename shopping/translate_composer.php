<?php
require_once 'vendor/autoload.php';

use SoftCreatR\PerplexityAI\PerplexityAI;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

// Your API Key
$apiKey = 'pplx-YOUR_API_KEY_HERE';

// Setup HTTP client and factories
$httpClient = new Client();
$httpFactory = new HttpFactory();

// Initialize Perplexity AI
$pplx = new PerplexityAI(
    $httpFactory,
    $httpFactory,
    $httpFactory,
    $httpClient,
    $apiKey
);

// Text to translate
$textToTranslate = 'Good morning, how can I help you?';
$targetLanguage = 'Spanish';

// Make translation request
$response = $pplx->createChatCompletion([], [
    'model' => 'sonar',
    'messages' => [
        [
            'role' => 'system',
            'content' => 'You are a professional translator. Provide only the translation.'
        ],
        [
            'role' => 'user',
            'content' => "Translate to $targetLanguage: \"$textToTranslate\""
        ]
    ],
    'max_tokens' => 500,
    'temperature' => 0.2
]);

// Process response
if ($response->getStatusCode() === 200) {
    $result = json_decode($response->getBody()->getContents(), true);
    $translation = $result['choices'][0]['message']['content'];
    
    echo "Original: $textToTranslate\n";
    echo "Translation ($targetLanguage): $translation\n";
} else {
    echo "Error: " . $response->getStatusCode();
}
?>
