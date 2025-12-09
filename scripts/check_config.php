<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

echo "--- CONFIG DIAGNOSIS START ---\n";

echo "APP_URL: " . config('app.url') . "\n";
echo "SESSION_DOMAIN: " . (config('session.domain') ?? 'NULL') . "\n";
echo "SESSION_SECURE_COOKIE: " . (config('session.secure') ? 'true' : 'false') . "\n";
echo "SESSION_SAME_SITE: " . config('session.same_site') . "\n";
echo "SESSION_LIFETIME: " . config('session.lifetime') . "\n";

echo "--- LOGS CHECK ---\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    // Read last 20 lines
    $lines = array_slice(file($logFile), -20);
    foreach ($lines as $line) {
        echo $line;
    }
} else {
    echo "Log file not found.\n";
}
echo "--- CONFIG DIAGNOSIS END ---\n";
