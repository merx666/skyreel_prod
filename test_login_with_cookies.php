<?php

echo "=== Test logowania z obsługą cookies ===\n";

$cookieJar = tempnam(sys_get_temp_dir(), 'cookies');
$loginUrl = 'https://skyreel.art/login';

// Krok 1: Pobierz stronę logowania i zapisz cookies
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $loginUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "1. Pobieranie strony logowania: HTTP $httpCode\n";

// Sprawdź czy mamy cookies
$cookieContent = file_get_contents($cookieJar);
if (strpos($cookieContent, 'skyreel') !== false) {
    echo "✅ Cookie sesyjny zapisany\n";
} else {
    echo "❌ Brak cookie sesyjnego\n";
}

// Wyciągnij token CSRF
preg_match('/<meta name="csrf-token" content="([^"]+)"/', $response, $matches);
$csrfToken = $matches[1] ?? null;

if ($csrfToken) {
    echo "✅ Token CSRF: " . substr($csrfToken, 0, 20) . "...\n";
} else {
    echo "❌ Brak tokenu CSRF\n";
    exit(1);
}

// Krok 2: Wyślij dane logowania używając tego samego cookie jar
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $loginUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $csrfToken,
    'email' => 'test@example.com',
    'password' => 'password123'
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_HEADER, true);

$loginResponse = curl_exec($ch);
$loginHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "2. Próba logowania: HTTP $loginHttpCode\n";

if ($loginHttpCode == 302) {
    echo "✅ Przekierowanie (prawdopodobnie udane logowanie)\n";
    // Sprawdź gdzie przekierowuje
    if (preg_match('/Location: (.+)/i', $loginResponse, $locationMatches)) {
        echo "   Przekierowanie do: " . trim($locationMatches[1]) . "\n";
    }
} elseif ($loginHttpCode == 422) {
    echo "❌ Błąd walidacji (422)\n";
    if (strpos($loginResponse, 'Podane dane logowania') !== false) {
        echo "   Nieprawidłowe dane logowania\n";
    }
} elseif ($loginHttpCode == 419) {
    echo "❌ Błąd CSRF (419)\n";
} elseif ($loginHttpCode == 500) {
    echo "❌ Błąd serwera (500)\n";
} else {
    echo "⚠️  Nieoczekiwany kod: $loginHttpCode\n";
}

// Wyczyść plik cookies
unlink($cookieJar);

echo "=== Koniec testu ===\n";
