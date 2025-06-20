<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== CHECKING TABLE STRUCTURES ===\n\n";

// Check users table
echo "Users table structure:\n";
$users = DB::select('DESCRIBE users');
foreach ($users as $column) {
    echo "- {$column->Field} ({$column->Type}) - Null: {$column->Null}, Default: " . ($column->Default ?? 'null') . "\n";
}

echo "\n";

// Check products table  
echo "Products table structure:\n";
$products = DB::select('DESCRIBE products');
foreach ($products as $column) {
    echo "- {$column->Field} ({$column->Type}) - Null: {$column->Null}, Default: " . ($column->Default ?? 'null') . "\n";
}

echo "\n";

// Check checkout_orders table
echo "Checkout orders table structure:\n";
$orders = DB::select('DESCRIBE checkout_orders');
foreach ($orders as $column) {
    echo "- {$column->Field} ({$column->Type}) - Null: {$column->Null}, Default: " . ($column->Default ?? 'null') . "\n";
}
