<?php

// Simple helper script to create or update a user with random password
// Target: name "merx", email "merx@skyreel.art"

try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $name = 'merx';
    $email = 'merx@skyreel.art';

    // Generate a random 16-character password
    $random = base64_encode(random_bytes(12));
    // Sanitize to URL/ASCII friendly characters
    $plainPassword = substr(strtr($random, '+/=', 'ABC'), 0, 16);
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Check if user exists by email
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // Update password only
        $upd = $pdo->prepare('UPDATE users SET password = ?, updated_at = datetime("now") WHERE id = ?');
        $upd->execute([$hashedPassword, $existing['id']]);
        echo "User already exists. Password updated.\n";
        echo "Email: {$email}\n";
        echo "New password: {$plainPassword}\n";
    } else {
        // Create new user with default role and timestamps
        $ins = $pdo->prepare('INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, datetime("now"), datetime("now"))');
        $ins->execute([$name, $email, $hashedPassword]);
        echo "User created successfully.\n";
        echo "Email: {$email}\n";
        echo "Password: {$plainPassword}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}