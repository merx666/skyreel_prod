<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Sprawdzanie sesji w bazie danych ===\n";

$sessions = DB::table('sessions')
    ->orderBy('last_activity', 'desc')
    ->limit(5)
    ->get(['id', 'user_agent', 'last_activity', 'ip_address']);

echo "Liczba sesji: " . $sessions->count() . "\n\n";

foreach ($sessions as $session) {
    echo "ID: " . substr($session->id, 0, 15) . "...\n";
    echo "IP: " . $session->ip_address . "\n";
    echo "User-Agent: " . substr($session->user_agent, 0, 50) . "...\n";
    echo "Last Activity: " . date('Y-m-d H:i:s', $session->last_activity) . "\n";
    echo "---\n";
}
