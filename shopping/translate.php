

<?php
$apiKey = getenv('PERPLEXITY_API_KEY');
if ($apiKey === false || $apiKey === '') {
    http_response_code(500);
    exit('Translation is unavailable: PERPLEXITY_API_KEY is not configured.');
}

// Text to translate
$textToTranslate = 'Hello, how are you today?';
$targetLanguage = 'French';

// API endpoint
$apiUrl = 'https://api.perplexity.ai/chat/completions';

// Prepare the request payload
$data = [
    'model' => 'sonar',
    'messages' => [
        [
            'role' => 'system',
            'content' => 'You are a professional translator. Provide only the translation without any explanation.'
        ],
        [
            'role' => 'user',
            'content' => "Translate the following text to $targetLanguage: \"$textToTranslate\""
        ]
    ],
    'max_tokens' => 500,
    'temperature' => 0.2
];

// Initialize cURL
$ch = curl_init($apiUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
]);

// Execute request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for errors
if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Process response
if ($httpCode == 200) {
    $result = json_decode($response, true);
    
    // Extract translated text
    $translatedText = $result['choices'][0]['message']['content'] ?? 'Translation failed';
    
    echo '<h3>Original Text:</h3>';
    echo '<p>' . htmlspecialchars($textToTranslate) . '</p>';
    echo '<h3>Translated Text (' . $targetLanguage . '):</h3>';
    echo '<p>' . htmlspecialchars($translatedText) . '</p>';
} else {
    echo 'API Error: ' . $httpCode . '<br>';
    echo 'Response: ' . $response;
}
?>
