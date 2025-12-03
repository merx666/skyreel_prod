<?php

// Test prostego POST do /login bez sesji
$url = 'https://skyreel.art/login';

// Najpierw pobierz stronę logowania
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://skyreel.art/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 Test');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "=== Test prostego POST do /login ===\n";
echo "GET /login HTTP Code: $httpCode\n";

// Sprawdź czy strona zawiera formularz
if (strpos($response, '<form') !== false) {
    echo "✅ Formularz logowania znaleziony\n";
} else {
    echo "❌ Brak formularza logowania\n";
}

// Test POST bez CSRF (powinien dać 419)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'email' => 'test@example.com',
    'password' => 'password123'
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 Test');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$postResponse = curl_exec($ch);
$postHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "POST /login HTTP Code: $postHttpCode\n";

if ($postHttpCode == 419) {
    echo "✅ Oczekiwany błąd CSRF (419)\n";
} elseif ($postHttpCode == 500) {
    echo "❌ Błąd serwera (500) - problem z aplikacją\n";
} else {
    echo "⚠️  Nieoczekiwany kod: $postHttpCode\n";
}

echo "=== Koniec testu ===\n";
