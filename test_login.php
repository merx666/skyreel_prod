<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Test credentials
    $email = 'merx@skyreel.art';
    $password = 'dupa123';
    
    echo "Testing login for: " . $email . PHP_EOL;
    echo "Password: " . $password . PHP_EOL;
    echo "---" . PHP_EOL;
    
    // Find user
    $user = \App\Models\User::where('email', $email)->first();
    
    if (!$user) {
        echo "ERROR: User not found" . PHP_EOL;
        exit(1);
    }
    
    echo "User found:" . PHP_EOL;
    echo "- ID: " . $user->id . PHP_EOL;
    echo "- Name: " . $user->name . PHP_EOL;
    echo "- Email: " . $user->email . PHP_EOL;
    echo "- Role: " . $user->role . PHP_EOL;
    echo "- Email verified: " . ($user->email_verified_at ? 'YES' : 'NO') . PHP_EOL;
    echo "---" . PHP_EOL;
    
    // Test password verification
    $passwordCheck = Hash::check($password, $user->password);
    echo "Password verification: " . ($passwordCheck ? 'SUCCESS' : 'FAILED') . PHP_EOL;
    
    if (!$passwordCheck) {
        echo "ERROR: Password does not match" . PHP_EOL;
        exit(1);
    }
    
    // Test Auth::attempt
    $credentials = [
        'email' => $email,
        'password' => $password
    ];
    
    $authAttempt = Auth::attempt($credentials);
    echo "Auth::attempt result: " . ($authAttempt ? 'SUCCESS' : 'FAILED') . PHP_EOL;
    
    if ($authAttempt) {
        echo "Login test: PASSED" . PHP_EOL;
        echo "User should be able to login successfully" . PHP_EOL;
    } else {
        echo "Login test: FAILED" . PHP_EOL;
        echo "There might be an issue with the authentication process" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    echo "Trace: " . $e->getTraceAsString() . PHP_EOL;
}