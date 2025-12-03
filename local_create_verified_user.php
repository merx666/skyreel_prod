<?php

// Helper: create or update a local user with a specific email & password and mark email as verified
// Target: name "merx", email "merx@skyreel.art", password "dupa123"

try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $name = 'merx';
    $email = 'merx@skyreel.art';
    $plainPassword = 'dupa123';

    // Use bcrypt explicitly for Laravel compatibility
    $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);
    $now = date('Y-m-d H:i:s');

    // Ensure users table exists
    $checkTable = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
    $tableExists = $checkTable->fetch(PDO::FETCH_ASSOC);
    if (!$tableExists) {
        throw new Exception("Table 'users' does not exist. Run migrations first.");
    }

    // Check if user exists by email
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // Update password and mark email verified
        $upd = $pdo->prepare('UPDATE users SET password = ?, email_verified_at = ?, updated_at = ? WHERE id = ?');
        $upd->execute([$hashedPassword, $now, $now, $existing['id']]);
        echo "User already exists. Password updated and email verified.\n";
        echo "Email: {$email}\n";
        echo "Password: {$plainPassword}\n";
    } else {
        // Create new user with timestamps and verified email
        $ins = $pdo->prepare('INSERT INTO users (name, email, password, email_verified_at, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');
        $ins->execute([$name, $email, $hashedPassword, $now, $now, $now]);
        echo "User created successfully and email verified.\n";
        echo "Email: {$email}\n";
        echo "Password: {$plainPassword}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}