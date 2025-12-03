<?php

// Test logowania poprzez POST request z tokenem CSRF
echo "=== Test logowania SkyReel ===\n";

// Krok 1: Pobierz stronę logowania i wyciągnij token CSRF
echo "1. Pobieranie tokenu CSRF...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://skyreel.art/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$loginPage = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode !== 200) {
    echo "BŁĄD: Nie można pobrać strony logowania (HTTP $httpCode)\n";
    exit(1);
}

// Wyciągnij token CSRF
preg_match('/name="_token" value="([^"]+)"/', $loginPage, $matches);
if (!isset($matches[1])) {
    echo "BŁĄD: Nie znaleziono tokenu CSRF\n";
    exit(1);
}

$csrfToken = $matches[1];
echo "Token CSRF: $csrfToken\n";

// Krok 2: Wyślij dane logowania
echo "\n2. Wysyłanie danych logowania...\n";
$postData = [
    '_token' => $csrfToken,
    'email' => 'fishexo@gmail.com',
    'password' => 'password123',
    'remember' => '0'
];

curl_setopt($ch, CURLOPT_URL, 'https://skyreel.art/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "HTTP Code: $httpCode\n";

// Sprawdź czy jest przekierowanie (sukces logowania)
if ($httpCode === 302) {
    echo "✅ SUKCES: Logowanie zakończone sukcesem (przekierowanie 302)\n";
    
    // Sprawdź nagłówek Location
    preg_match('/Location: (.+)/', $response, $locationMatches);
    if (isset($locationMatches[1])) {
        echo "Przekierowanie do: " . trim($locationMatches[1]) . "\n";
    }
} elseif ($httpCode === 419) {
    echo "❌ BŁĄD 419: PAGE EXPIRED - problem z tokenem CSRF\n";
} elseif ($httpCode === 422) {
    echo "❌ BŁĄD 422: Niepoprawne dane logowania\n";
} else {
    echo "❌ BŁĄD: Nieoczekiwany kod HTTP: $httpCode\n";
}

// Sprawdź czy w odpowiedzi są błędy
if (strpos($response, '419') !== false || strpos($response, 'PAGE EXPIRED') !== false) {
    echo "❌ Znaleziono błąd 419 PAGE EXPIRED w odpowiedzi\n";
}

if (strpos($response, 'These credentials do not match') !== false) {
    echo "❌ Niepoprawne dane logowania\n";
}

curl_close($ch);

// Wyczyść plik cookies
@unlink('/tmp/cookies.txt');

echo "\n=== Koniec testu ===\n";