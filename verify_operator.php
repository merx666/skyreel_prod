<?php

// Helper script: mark user verified and set role to 'operator'
// Target email: merx@skyreel.art

try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $email = 'merx@skyreel.art';

    // Check if user exists
    $stmt = $pdo->prepare('SELECT id, name, role, email_verified_at FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found: {$email}\n";
        exit(1);
    }

    // Update role and verification timestamp
    $upd = $pdo->prepare('UPDATE users SET role = ?, email_verified_at = datetime("now"), updated_at = datetime("now") WHERE id = ?');
    $upd->execute(['operator', $user['id']]);

    echo "User updated successfully.\n";
    echo "Email: {$email}\n";
    echo "Role: operator\n";
    echo "Email verified: now\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}