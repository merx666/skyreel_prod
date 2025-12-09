<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Manually boot for console-like usage if needed, but the above usually suffices for app context
// However, since we are a script, we might just want to reach into the app.

echo "--- AUTH DIAGNOSIS START ---\n";

try {
    // 1. Check DB Connection
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        echo "[PASS] Database connection successful.\n";
    } catch (\Exception $e) {
        echo "[FAIL] Database connection failed: " . $e->getMessage() . "\n";
        exit(1);
    }

    // 2. Try to create a user
    $testEmail = 'diag_' . time() . '@example.com';
    $password = 'password123';
    
    echo "Attempting to create user: $testEmail\n";

    \Illuminate\Support\Facades\DB::beginTransaction();

    try {
        $user = \App\Models\User::create([
            'name' => 'Diag User',
            'email' => $testEmail,
            'password' => bcrypt($password),
            'role' => 'client',
        ]);
        
        if (!$user->exists) {
            throw new \Exception("User model created but not persisted?");
        }
        echo "[PASS] User creation successful. ID: " . $user->id . "\n";

        // 3. Try creating profile
        $user->profile()->create([]);
        if ($user->profile) {
             echo "[PASS] Profile creation successful.\n";
        } else {
             echo "[FAIL] Profile relation failed.\n";
        }

    } catch (\Exception $e) {
        echo "[FAIL] User/Profile creation exception: " . $e->getMessage() . "\n";
        \Illuminate\Support\Facades\DB::rollBack();
        exit(1);
    }

    // 4. Test Login
    if (\Illuminate\Support\Facades\Auth::attempt(['email' => $testEmail, 'password' => $password])) {
        echo "[PASS] Auth::attempt returned true.\n";
        
        $loggedInUser = \Illuminate\Support\Facades\Auth::user();
        echo "Logged in user ID: " . $loggedInUser->id . "\n";
    } else {
        echo "[FAIL] Auth::attempt returned false.\n";
    }

    // 5. Check Session Config
    $sessionDriver = config('session.driver');
    echo "Session Driver: " . $sessionDriver . "\n";
    $sessionPath = config('session.files');
    if ($sessionDriver === 'file') {
        echo "Session Path: $sessionPath\n";
        if (!is_writable($sessionPath)) {
            echo "[WARN] Session path is NOT writable!\n";
        } else {
            echo "[PASS] Session path is writable.\n";
        }
    }

    // Rollback to keep DB clean
    \Illuminate\Support\Facades\DB::rollBack();
    echo "Rolled back transaction (cleanup).\n";

} catch (\Throwable $e) {
    echo "[CRITICAL ERROR] " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

echo "--- AUTH DIAGNOSIS END ---\n";
