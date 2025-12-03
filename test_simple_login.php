<?php

echo "=== Prosty test logowania ===\n";

// Test 1: Pobierz stronę logowania
echo "1. Pobieranie strony logowania...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://skyreel.art/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/simple_cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/simple_cookies.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; TestBot/1.0)');

$loginPage = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode !== 200) {
    echo "❌ Błąd pobierania strony logowania: HTTP $httpCode\n";
    exit(1);
}

// Wyciągnij token CSRF
preg_match('/name="_token" value="([^"]+)"/', $loginPage, $matches);
if (!isset($matches[1])) {
    echo "❌ Nie znaleziono tokenu CSRF\n";
    exit(1);
}

$csrfToken = $matches[1];
echo "✅ Token CSRF: $csrfToken\n";

// Test 2: Wyślij dane logowania z poprawnym tokenem
echo "2. Wysyłanie danych logowania...\n";
$postData = [
    '_token' => $csrfToken,
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

$loginResponse = curl_exec($ch);
$loginHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "HTTP Code: $loginHttpCode\n";

if ($loginHttpCode === 302) {
    $redirectUrl = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    echo "✅ Przekierowanie na: $redirectUrl\n";
    
    if (strpos($redirectUrl, '/dashboard') !== false) {
        echo "✅ SUKCES: Logowanie zakończone pomyślnie!\n";
    } else {
        echo "⚠️  Przekierowanie na nieoczekiwaną stronę\n";
    }
} elseif ($loginHttpCode === 419) {
    echo "❌ Błąd 419: Problem z tokenem CSRF\n";
} elseif ($loginHttpCode === 422) {
    echo "❌ Błąd 422: Nieprawidłowe dane logowania\n";
} elseif ($loginHttpCode === 500) {
    echo "❌ Błąd 500: Błąd serwera\n";
} else {
    echo "❌ Nieoczekiwany kod HTTP: $loginHttpCode\n";
}

curl_close($ch);

// Wyczyść pliki cookies
@unlink('/tmp/simple_cookies.txt');

echo "=== Koniec testu ===\n";