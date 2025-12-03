<?php

echo "=== Debug test logowania ===\n";

// Test 1: Pobierz stronę logowania z różnymi User-Agent
$userAgents = [
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
    'curl/7.68.0',
    'PHP Test Script'
];

foreach ($userAgents as $index => $userAgent) {
    echo "\n" . ($index + 1) . ". Test z User-Agent: $userAgent\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://skyreel.art/login');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/cookies_$index.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "/tmp/cookies_$index.txt");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    
    echo "   HTTP Code: $httpCode\n";
    
    if ($httpCode === 200) {
        $headers = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);
        
        // Sprawdź czy są cookies sesyjne
        if (preg_match('/Set-Cookie: skyreel_session=([^;]+)/', $headers, $matches)) {
            echo "   ✅ Cookie sesyjny znaleziony: " . substr($matches[1], 0, 20) . "...\n";
        } else {
            echo "   ❌ Brak cookie sesyjnego\n";
        }
        
        // Sprawdź token CSRF
        if (preg_match('/name="_token" value="([^"]+)"/', $body, $matches)) {
            echo "   ✅ Token CSRF znaleziony: " . substr($matches[1], 0, 20) . "...\n";
            
            // Spróbuj zalogować się z tym tokenem
            echo "   Próba logowania...\n";
            
            $postData = [
                '_token' => $matches[1],
                'email' => 'fishexo@gmail.com',
                'password' => 'password123'
            ];
            
            curl_setopt($ch, CURLOPT_URL, 'https://skyreel.art/login');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
                'Referer: https://skyreel.art/login'
            ]);
            curl_setopt($ch, CURLOPT_HEADER, false);
            
            $loginResponse = curl_exec($ch);
            $loginHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            echo "   Login HTTP Code: $loginHttpCode\n";
            
            if ($loginHttpCode === 302) {
                echo "   ✅ Przekierowanie - prawdopodobnie sukces!\n";
            } elseif ($loginHttpCode === 419) {
                echo "   ❌ Błąd 419 - problem z CSRF\n";
            } elseif ($loginHttpCode === 500) {
                echo "   ❌ Błąd 500 - błąd serwera\n";
            } else {
                echo "   ⚠️  Nieoczekiwany kod: $loginHttpCode\n";
            }
            
        } else {
            echo "   ❌ Brak tokenu CSRF w odpowiedzi\n";
        }
        
    } else {
        echo "   ❌ Błąd pobierania strony: $httpCode\n";
    }
    
    curl_close($ch);
    @unlink("/tmp/cookies_$index.txt");
}

echo "\n=== Koniec debugowania ===\n";