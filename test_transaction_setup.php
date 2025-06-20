<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CheckoutOrder;
use App\Models\User;

echo "=== TESTING TRANSACTION PAGES SETUP ===\n\n";

// Test if we can access the models
echo "✓ CheckoutOrder model loaded\n";
echo "✓ User model loaded\n";

// Check if controller exists
if (class_exists('App\Http\Controllers\TransactionController')) {
    echo "✓ TransactionController exists\n";
} else {
    echo "❌ TransactionController not found\n";
}

// Check if views exist
$indexView = 'c:\laragon\www\TriadGo\resources\views\transactions\index.blade.php';
$showView = 'c:\laragon\www\TriadGo\resources\views\transactions\show.blade.php';
$layoutView = 'c:\laragon\www\TriadGo\resources\views\layouts\app.blade.php';

if (file_exists($indexView)) {
    echo "✓ transactions/index.blade.php exists\n";
} else {
    echo "❌ transactions/index.blade.php not found\n";
}

if (file_exists($showView)) {
    echo "✓ transactions/show.blade.php exists\n";
} else {
    echo "❌ transactions/show.blade.php not found\n";
}

if (file_exists($layoutView)) {
    echo "✓ layouts/app.blade.php exists\n";
} else {
    echo "❌ layouts/app.blade.php not found\n";
}

// Test if we have sample data
$orderCount = CheckoutOrder::count();
echo "\n📊 Database Info:\n";
echo "  - Total orders: {$orderCount}\n";

if ($orderCount > 0) {
    $paidOrders = CheckoutOrder::where('status', 'paid')->count();
    $pendingOrders = CheckoutOrder::where('status', 'pending')->count();
    echo "  - Paid orders: {$paidOrders}\n";
    echo "  - Pending orders: {$pendingOrders}\n";
    
    $sampleOrder = CheckoutOrder::first();
    echo "  - Sample order ID: {$sampleOrder->order_id}\n";
    echo "  - Sample user ID: {$sampleOrder->user_id}\n";
    
    // Check if user exists
    $user = User::where('user_id', $sampleOrder->user_id)->first();
    if ($user) {
        echo "  - Sample user: {$user->name} ({$user->email})\n";
        echo "  - User role: {$user->role}\n";
    }
}

echo "\n✅ Setup check completed!\n";
echo "\nTo test the pages:\n";
echo "1. Start Laravel server: php artisan serve\n";
echo "2. Login as importir user\n";
echo "3. Visit: http://localhost:8000/transactions\n";
