<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => 'database/database.sqlite',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    $users = Capsule::table('users')->where('email', 'fishexo@gmail.com')->get();
    
    if ($users->count() > 0) {
        echo "User found:\n";
        foreach ($users as $user) {
            echo "ID: " . $user->id . "\n";
            echo "Name: " . $user->name . "\n";
            echo "Email: " . $user->email . "\n";
            echo "Role: " . $user->role . "\n";
            echo "Email verified: " . ($user->email_verified_at ? 'Yes' : 'No') . "\n";
            echo "Created: " . $user->created_at . "\n";
            echo "Password hash: " . substr($user->password, 0, 20) . "...\n";
        }
    } else {
        echo "User NOT found in database\n";
        
        // Show all users for debugging
        echo "\nAll users in database:\n";
        $allUsers = Capsule::table('users')->select('id', 'name', 'email', 'role')->get();
        foreach ($allUsers as $user) {
            echo "- ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}