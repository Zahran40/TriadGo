<?php
// Test creating products table manually
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== MANUAL TABLE CREATION TEST ===\n";
    
    // Try to create products table manually
    $sql = "CREATE TABLE IF NOT EXISTS products_test (
        product_id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        product_description TEXT,
        category VARCHAR(255),
        price DECIMAL(10,2),
        stock_quantity INTEGER,
        product_sku VARCHAR(255) UNIQUE,
        weight DECIMAL(8,2),
        country_of_origin VARCHAR(255),
        product_image VARCHAR(255),
        status VARCHAR(50) DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Test products table created successfully!\n";
    
    // Insert test data
    $insertSql = "INSERT INTO products_test (user_id, product_name, product_description, category, price, stock_quantity, product_sku, weight, country_of_origin, status) 
                  VALUES (1, 'Test Product', 'Test Description', 'Food', 10.50, 100, 'TEST001', 1.5, 'Indonesia', 'approved')";
    
    $pdo->exec($insertSql);
    echo "Test data inserted!\n";
    
    // Check data
    $stmt = $pdo->query("SELECT * FROM products_test");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Data found: " . count($data) . "\n";
    foreach($data as $row) {
        echo "ID: " . $row['product_id'] . ", Name: " . $row['product_name'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
