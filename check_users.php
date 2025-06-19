<?php
// Direct SQLite connection to check users
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== CHECKING IMPORTIR USERS ===\n";
    $stmt = $pdo->query("SELECT user_id, first_name, last_name, email, role, country FROM users WHERE role = 'impor' LIMIT 5");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Importir users found: " . count($users) . "\n\n";
    
    foreach($users as $user) {
        echo "ID: " . $user['user_id'] . "\n";
        echo "Name: " . $user['first_name'] . " " . $user['last_name'] . "\n";
        echo "Email: " . $user['email'] . "\n";
        echo "Country: " . $user['country'] . "\n";
        echo "Role: " . $user['role'] . "\n";
        echo "Password: password123 (from seeder)\n";
        echo "---\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
