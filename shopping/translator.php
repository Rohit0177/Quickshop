<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perplexity AI Translator</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        textarea { width: 100%; height: 150px; padding: 10px; font-size: 14px; }
        select, button { padding: 10px; font-size: 14px; margin: 10px 0; }
        button { background: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
        .result { background: #f4f4f4; padding: 15px; margin-top: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Perplexity AI Language Translator</h1>
    
    <form method="POST">
        <label><strong>Enter Text to Translate:</strong></label><br>
        <textarea name="text_input" required><?php echo isset($_POST['text_input']) ? htmlspecialchars($_POST['text_input']) : ''; ?></textarea>
        
        <br><label><strong>Target Language:</strong></label><br>
        <select name="target_language" required>
            <option value="Spanish">Spanish</option>
            <option value="French">French</option>
            <option value="German">German</option>
            <option value="Hindi">Hindi</option>
            <option value="Chinese">Chinese</option>
            <option value="Japanese">Japanese</option>
            <option value="Arabic">Arabic</option>
            <option value="Portuguese">Portuguese</option>
            <option value="Russian">Russian</option>
            <option value="Italian">Italian</option>
        </select>
        
        <br><button type="submit" name="translate">Translate</button>
    </form>

    <?php
    if (isset($_POST['translate'])) {
        // Your Perplexity API Key
        $apiKey = 'pplx-YOUR_API_KEY_HERE';
        
        $textToTranslate = $_POST['text_input'];
        $targetLanguage = $_POST['target_language'];
        
        // API endpoint
        $apiUrl = 'https://api.perplexity.ai/chat/completions';
        
        // Prepare request
        $data = [
            'model' => 'sonar',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a professional translator. Provide only the translation without any explanation or additional text.'
                ],
                [
                    'role' => 'user',
                    'content' => "Translate this text to $targetLanguage: \"$textToTranslate\""
                ]
            ],
            'max_tokens' => 1000,
            'temperature' => 0.2
        ];
        
        // Initialize cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ]);
        
        // Execute
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // Display result
        if ($httpCode == 200) {
            $result = json_decode($response, true);
            $translatedText = $result['choices'][0]['message']['content'] ?? 'Translation failed';
            
            echo '<div class="result">';
            echo '<h3>Translation Result:</h3>';
            echo '<p><strong>Original:</strong> ' . htmlspecialchars($textToTranslate) . '</p>';
            echo '<p><strong>' . htmlspecialchars($targetLanguage) . ':</strong> ' . htmlspecialchars($translatedText) . '</p>';
            echo '</div>';
        } else {
            echo '<div class="result" style="background: #ffcccc;">';
            echo '<strong>Error:</strong> Failed to translate. HTTP Code: ' . $httpCode;
            echo '</div>';
        }
    }
    ?>
</body>
</html>
