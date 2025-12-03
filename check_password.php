<?php

try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare('SELECT password FROM users WHERE email = ?');
    $stmt->execute(['fishexo@gmail.com']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "Password hash: " . $user['password'] . PHP_EOL;
        echo "Hash starts with \$2y\$: " . (strpos($user['password'], '$2y$') === 0 ? 'YES' : 'NO') . PHP_EOL;
        echo "Hash length: " . strlen($user['password']) . PHP_EOL;
        
        // Test if password verification works with a common password
        $testPasswords = ['password', '123456', 'admin', 'test', 'fishexo'];
        foreach ($testPasswords as $testPassword) {
            if (password_verify($testPassword, $user['password'])) {
                echo "Password matches: " . $testPassword . PHP_EOL;
                break;
            }
        }
    } else {
        echo "User not found" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}