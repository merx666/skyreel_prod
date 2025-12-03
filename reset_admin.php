<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::where('email', 'admin@skyreel.art')->first();
if ($user) {
    $user->password = \Illuminate\Support\Facades\Hash::make('AdminPass2024!');
    $user->save();
    echo "Password updated successfully for admin@skyreel.art\n";
} else {
    echo "User admin@skyreel.art not found.\n";
}
