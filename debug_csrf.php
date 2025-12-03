<?php

// Debug CSRF problem
echo "=== Debug CSRF SkyReel ===\n";

// Krok 1: Pobierz stronę logowania z pełnymi nagłówkami
echo "1. Pobieranie strony logowania z nagłówkami...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://skyreel.art/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/debug_cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/debug_cookies.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "HTTP Code: $httpCode\n";

// Wyciągnij nagłówki
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $headerSize);
$body = substr($response, $headerSize);

echo "\n=== NAGŁÓWKI ODPOWIEDZI ===\n";
echo $headers;

// Sprawdź cookies
echo "\n=== COOKIES ===\n";
if (file_exists('/tmp/debug_cookies.txt')) {
    echo file_get_contents('/tmp/debug_cookies.txt');
} else {
    echo "Brak pliku cookies\n";
}

// Wyciągnij token CSRF
preg_match('/name="_token" value="([^"]+)"/', $body, $matches);
if (!isset($matches[1])) {
    echo "\n❌ BŁĄD: Nie znaleziono tokenu CSRF\n";
    exit(1);
}

$csrfToken = $matches[1];
echo "\n=== TOKEN CSRF ===\n";
echo "Token: $csrfToken\n";

// Sprawdź meta tag csrf-token
preg_match('/name="csrf-token" content="([^"]+)"/', $body, $metaMatches);
if (isset($metaMatches[1])) {
    echo "Meta CSRF: {$metaMatches[1]}\n";
    if ($csrfToken !== $metaMatches[1]) {
        echo "⚠️  UWAGA: Token z formularza różni się od meta tagu!\n";
    }
} else {
    echo "❌ Brak meta tagu csrf-token\n";
}

// Krok 2: Wyślij dane logowania z dodatkowymi nagłówkami
echo "\n2. Wysyłanie danych logowania z dodatkowymi nagłówkami...\n";
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
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'X-Requested-With: XMLHttpRequest',
    'Referer: https://skyreel.art/login',
    'Origin: https://skyreel.art'
]);

$loginResponse = curl_exec($ch);
$loginHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "HTTP Code: $loginHttpCode\n";

// Wyciągnij nagłówki odpowiedzi logowania
$loginHeaderSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$loginHeaders = substr($loginResponse, 0, $loginHeaderSize);
$loginBody = substr($loginResponse, $loginHeaderSize);

echo "\n=== NAGŁÓWKI ODPOWIEDZI LOGOWANIA ===\n";
echo $loginHeaders;

if ($loginHttpCode === 419) {
    echo "\n❌ Nadal błąd 419 - sprawdzam szczegóły...\n";
    
    // Sprawdź czy w odpowiedzi jest informacja o błędzie
    if (strpos($loginBody, 'CSRF token mismatch') !== false) {
        echo "Znaleziono: CSRF token mismatch\n";
    }
    if (strpos($loginBody, 'TokenMismatchException') !== false) {
        echo "Znaleziono: TokenMismatchException\n";
    }
}

curl_close($ch);

// Wyczyść pliki cookies
@unlink('/tmp/debug_cookies.txt');

echo "\n=== Koniec debugowania ===\n";