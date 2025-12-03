<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a fake request
$request = Request::create('https://skyreel.art/test-session', 'GET');
$response = $kernel->handle($request);

echo "=== Test zapisu sesji ===\n";

try {
    // Start session
    session_start();
    
    // Test basic session write
    $_SESSION['test'] = 'value';
    echo "✅ Session write successful\n";
    
    // Test Laravel session
    $session = app('session');
    $session->put('laravel_test', 'laravel_value');
    $session->save();
    echo "✅ Laravel session write successful\n";
    
    echo "Session ID: " . session_id() . "\n";
    echo "Session data: " . json_encode($_SESSION) . "\n";
    
} catch (Exception $e) {
    echo "❌ Session error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "=== Koniec testu ===\n";