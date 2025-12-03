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
    $updated = Capsule::table('users')
        ->where('email', 'fishexo@gmail.com')
        ->update(['email_verified_at' => date('Y-m-d H:i:s')]);
    
    if ($updated > 0) {
        echo "Email verified successfully for fishexo@gmail.com\n";
        
        // Verify the update
        $user = Capsule::table('users')->where('email', 'fishexo@gmail.com')->first();
        echo "Email verified at: " . $user->email_verified_at . "\n";
    } else {
        echo "No user found with email fishexo@gmail.com\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}