<?php
require_once 'vendor/autoload.php';

echo "=== Test logowania z prawdziwymi danymi ===\n";

// Inicjalizacja cURL z obsługą cookies
$cookieJar = tempnam(sys_get_temp_dir(), 'cookies');
$ch = curl_init();

// Konfiguracja cURL
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => false,
    CURLOPT_COOKIEJAR => $cookieJar,
    CURLOPT_COOKIEFILE => $cookieJar,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HEADER => true,
]);

// 1. Pobierz stronę logowania
echo "1. Pobieranie strony logowania: ";
curl_setopt($ch, CURLOPT_URL, 'https://skyreel.art/login');
curl_setopt($ch, CURLOPT_HTTPGET, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP $httpCode\n";

if ($httpCode !== 200) {
    echo "❌ Błąd pobierania strony logowania\n";
    curl_close($ch);
    unlink($cookieJar);
    exit(1);
}

// Sprawdź czy otrzymaliśmy cookie sesyjny
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $headerSize);
$body = substr($response, $headerSize);

if (preg_match('/Set-Cookie:\s*laravel_session=([^;]+)/i', $headers, $matches)) {
    echo "✅ Cookie sesyjny: " . substr($matches[1], 0, 20) . "...\n";
} else {
    echo "❌ Brak cookie sesyjnego\n";
}

// Wyciągnij token CSRF
if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $body, $matches)) {
    $csrfToken = $matches[1];
    echo "✅ Token CSRF: " . substr($csrfToken, 0, 20) . "...\n";
} else {
    echo "❌ Brak tokenu CSRF\n";
    curl_close($ch);
    unlink($cookieJar);
    exit(1);
}

// 2. Próba logowania z prawdziwymi danymi
echo "2. Próba logowania z prawdziwymi danymi: ";
curl_setopt($ch, CURLOPT_URL, 'https://skyreel.art/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $csrfToken,
    'email' => 'fishexo@gmail.com',
    'password' => 'password123',
    'remember' => 'on'
]));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP $httpCode\n";

// Sprawdź przekierowanie
if ($httpCode === 302) {
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $headerSize);
    
    if (preg_match('/Location:\s*(.+)/i', $headers, $matches)) {
        $location = trim($matches[1]);
        echo "✅ Przekierowanie do: $location\n";
        
        if (strpos($location, '/dashboard') !== false) {
            echo "✅ Logowanie udane - przekierowanie do dashboard\n";
        } elseif (strpos($location, '/login') !== false) {
            echo "❌ Logowanie nieudane - przekierowanie z powrotem do login\n";
        } else {
            echo "⚠️  Nieoczekiwane przekierowanie\n";
        }
    }
} elseif ($httpCode === 200) {
    echo "❌ Brak przekierowania - prawdopodobnie błąd logowania\n";
} else {
    echo "❌ Nieoczekiwany kod odpowiedzi\n";
}

// 3. Sprawdź czy jesteśmy zalogowani - próbuj dostać się do dashboard
echo "3. Sprawdzanie dostępu do dashboard: ";
curl_setopt($ch, CURLOPT_URL, 'https://skyreel.art/dashboard');
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP $httpCode\n";

if ($httpCode === 200) {
    echo "✅ Dostęp do dashboard - użytkownik zalogowany\n";
} elseif ($httpCode === 302) {
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $headerSize);
    
    if (preg_match('/Location:\s*(.+)/i', $headers, $matches)) {
        $location = trim($matches[1]);
        echo "❌ Przekierowanie do: $location - użytkownik niezalogowany\n";
    }
} else {
    echo "❌ Nieoczekiwany kod odpowiedzi\n";
}

echo "=== Koniec testu ===\n";

curl_close($ch);
unlink($cookieJar);
?>