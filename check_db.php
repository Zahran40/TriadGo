<?php
// Direct SQLite connection
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== CHECKING PRODUCTS TABLE ===\n";
    $stmt = $pdo->query("SELECT product_id, product_name, price, status FROM products LIMIT 10");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total products found: " . count($products) . "\n\n";
    
    foreach($products as $product) {
        echo "ID: " . $product['product_id'] . "\n";
        echo "Name: " . $product['product_name'] . "\n";
        echo "Price: " . $product['price'] . "\n";
        echo "Status: " . ($product['status'] ?? 'NULL') . "\n";
        echo "---\n";
    }
    
    // Check specific product ID 8
    $stmt8 = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt8->execute([8]);
    $product8 = $stmt8->fetch(PDO::FETCH_ASSOC);
    
    echo "\n=== PRODUCT ID 8 CHECK ===\n";
    if ($product8) {
        echo "Product 8 EXISTS:\n";
        echo "Name: " . $product8['product_name'] . "\n";
        echo "Status: " . ($product8['status'] ?? 'NULL') . "\n";
        echo "User ID: " . $product8['user_id'] . "\n";
    } else {
        echo "Product 8 NOT FOUND\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
