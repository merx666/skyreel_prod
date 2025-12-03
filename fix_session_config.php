<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

echo "=== Naprawa konfiguracji sesji SkyReel ===\n";

// Ustaw zmienne środowiskowe
$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    echo "BŁĄD: Plik .env nie istnieje\n";
    exit(1);
}

$envContent = file_get_contents($envFile);

// Funkcja do aktualizacji lub dodania zmiennej środowiskowej
function updateEnvVariable($content, $key, $value) {
    $pattern = "/^{$key}=.*$/m";
    $replacement = "{$key}={$value}";
    
    if (preg_match($pattern, $content)) {
        return preg_replace($pattern, $replacement, $content);
    } else {
        return $content . "\n{$replacement}";
    }
}

echo "1. Aktualizacja konfiguracji sesji...\n";

// Aktualizuj konfigurację sesji
$envContent = updateEnvVariable($envContent, 'SESSION_DRIVER', 'database');
$envContent = updateEnvVariable($envContent, 'SESSION_DOMAIN', 'skyreel.art');
$envContent = updateEnvVariable($envContent, 'SESSION_SECURE_COOKIE', 'true');

// Zapisz plik .env
file_put_contents($envFile, $envContent);

echo "2. Czyszczenie cache konfiguracji...\n";
exec('php artisan config:clear');

echo "3. Sprawdzenie nowej konfiguracji...\n";
exec('php artisan config:show session', $output);
foreach ($output as $line) {
    if (strpos($line, 'driver') !== false || 
        strpos($line, 'domain') !== false || 
        strpos($line, 'secure') !== false) {
        echo "  $line\n";
    }
}

echo "\n✅ Konfiguracja sesji została zaktualizowana!\n";
echo "=== Koniec naprawy ===\n";