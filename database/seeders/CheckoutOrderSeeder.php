<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CheckoutOrder;
use App\Models\User;

class CheckoutOrderSeeder extends Seeder
{
    public function run()
    {
        // Get importir users
        $importirs = User::where('role', 'impor')->get();
        
        if ($importirs->isEmpty()) {
            echo "No importir users found. Please create importir users first.\n";
            return;
        }

        $sampleOrders = [
            [
                'order_id' => 'ORD-' . time() . '-001',
                'total_amount' => 299.99,
                'currency' => 'USD',
                'status' => 'paid',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+60123456789',
                'address' => '123 Business Street',
                'city' => 'Kuala Lumpur',
                'state' => 'Selangor',
                'zip_code' => '50000',
                'country' => 'MY',
                'payment_method' => 'midtrans',
                'cart_items' => [
                    [
                        'id' => 'PROD001',
                        'name' => 'Premium Coffee Beans',
                        'price' => 25.50,
                        'quantity' => 10,
                        'category' => 'Food & Beverages',
                        'sku' => 'TD-1',
                        'weight' => 1.0
                    ],
                    [
                        'id' => 'PROD002',
                        'name' => 'Handwoven Batik Fabric',
                        'price' => 45.00,
                        'quantity' => 1,
                        'category' => 'Fashion',
                        'sku' => 'TD-2',
                        'weight' => 0.5
                    ]
                ],
                'subtotal' => 300.00,
                'shipping_cost' => 15.00,
                'tax_amount' => 0.00,
                'discount_amount' => 15.01,
                'payment_gateway_transaction_id' => 'TXN-' . uniqid(),
                'payment_completed_at' => now()->subDays(2)
            ],
            [
                'order_id' => 'ORD-' . time() . '-002',
                'total_amount' => 150.75,
                'currency' => 'USD',
                'status' => 'pending',
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'maria.santos@email.com',
                'phone' => '+6281234567890',
                'address' => '456 Trade Avenue',
                'city' => 'Jakarta',
                'state' => 'DKI Jakarta',
                'zip_code' => '12345',
                'country' => 'ID',
                'payment_method' => 'midtrans',
                'cart_items' => [
                    [
                        'id' => 'PROD003',
                        'name' => 'Natural Rubber Sheets',
                        'price' => 150.75,
                        'quantity' => 1,
                        'category' => 'Industrial',
                        'sku' => 'TD-4',
                        'weight' => 5.0
                    ]
                ],
                'subtotal' => 150.75,
                'shipping_cost' => 0.00,
                'tax_amount' => 0.00,
                'discount_amount' => 0.00
            ],
            [
                'order_id' => 'ORD-' . time() . '-003',
                'total_amount' => 89.50,
                'currency' => 'USD',
                'status' => 'paid',
                'first_name' => 'David',
                'last_name' => 'Chen',
                'email' => 'david.chen@company.com',
                'phone' => '+6591234567',
                'address' => '789 Import Lane',
                'city' => 'Singapore',
                'state' => 'Central',
                'zip_code' => '123456',
                'country' => 'SG',
                'payment_method' => 'midtrans',
                'cart_items' => [
                    [
                        'id' => 'PROD004',
                        'name' => 'Virgin Coconut Oil',
                        'price' => 22.50,
                        'quantity' => 4,
                        'category' => 'Health',
                        'sku' => 'TD-5',
                        'weight' => 0.5
                    ]
                ],
                'subtotal' => 90.00,
                'shipping_cost' => 5.00,
                'tax_amount' => 4.50,
                'discount_amount' => 10.00,
                'coupon_code' => 'WELCOME10',
                'payment_gateway_transaction_id' => 'TXN-' . uniqid(),
                'payment_completed_at' => now()->subHours(6)
            ],
            [
                'order_id' => 'ORD-' . time() . '-004',
                'total_amount' => 500.00,
                'currency' => 'USD',
                'status' => 'failed',
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'email' => 'sarah.johnson@business.com',
                'phone' => '+66812345678',
                'address' => '321 Commerce Road',
                'city' => 'Bangkok',
                'state' => 'Bangkok',
                'zip_code' => '10100',
                'country' => 'TH',
                'payment_method' => 'midtrans',
                'cart_items' => [
                    [
                        'id' => 'PROD005',
                        'name' => 'Premium Teak Wood Furniture',
                        'price' => 500.00,
                        'quantity' => 1,
                        'category' => 'Furniture',
                        'sku' => 'TD-3',
                        'weight' => 25.0
                    ]
                ],
                'subtotal' => 500.00,
                'shipping_cost' => 50.00,
                'tax_amount' => 25.00,
                'discount_amount' => 75.00,
                'notes' => 'Please handle with care - fragile furniture'
            ]
        ];

        foreach ($sampleOrders as $index => $orderData) {
            // Assign to different importirs cyclically
            $importir = $importirs[$index % $importirs->count()];
            
            CheckoutOrder::create($orderData);
        }

        echo "Sample checkout orders created successfully!\n";
        echo "- Total Orders: " . CheckoutOrder::count() . "\n";
        echo "- Paid Orders: " . CheckoutOrder::where('status', 'paid')->count() . "\n";
        echo "- Pending Orders: " . CheckoutOrder::where('status', 'pending')->count() . "\n";
        echo "- Failed Orders: " . CheckoutOrder::where('status', 'failed')->count() . "\n";
        echo "- Total Revenue: $" . number_format(CheckoutOrder::where('status', 'paid')->sum('total_amount'), 2) . "\n";
    }
}
