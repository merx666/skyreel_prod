<?php

try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set new password to 'password123'
    $newPassword = 'password123';
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
    $result = $stmt->execute([$hashedPassword, 'fishexo@gmail.com']);
    
    if ($result && $stmt->rowCount() > 0) {
        echo "Password reset successfully for fishexo@gmail.com" . PHP_EOL;
        echo "New password: " . $newPassword . PHP_EOL;
        echo "Hash: " . $hashedPassword . PHP_EOL;
        
        // Verify the update
        $stmt = $pdo->prepare('SELECT password FROM users WHERE email = ?');
        $stmt->execute(['fishexo@gmail.com']);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($newPassword, $user['password'])) {
            echo "Password verification: SUCCESS" . PHP_EOL;
        } else {
            echo "Password verification: FAILED" . PHP_EOL;
        }
    } else {
        echo "Failed to update password" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}