<?php
// Direct SQLite connection
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== CHECKING DATABASE TABLES ===\n";
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tables found:\n";
    foreach($tables as $table) {
        echo "- " . $table . "\n";
    }
    
    // Check if products table exists with different name or schema
    foreach($tables as $table) {
        if (strpos(strtolower($table), 'product') !== false) {
            echo "\n=== CHECKING TABLE: $table ===\n";
            $stmt = $pdo->query("PRAGMA table_info($table)");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($columns as $col) {
                echo "Column: " . $col['name'] . " (" . $col['type'] . ")\n";
            }
            
            // Try to get some data
            $stmt = $pdo->query("SELECT * FROM $table LIMIT 5");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "Row count: " . count($data) . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
