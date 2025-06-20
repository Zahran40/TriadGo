<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CheckoutOrder;
use App\Models\User;

class DemoOrderSeederClean extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Find an importer user
        $importer = User::where('role', 'impor')->first();
        
        if (!$importer) {
            // Create a demo importer if none exists
            $importer = User::create([
                'name' => 'Demo Importer',
                'email' => 'importer@demo.com',
                'password' => bcrypt('password'),
                'role' => 'impor',
                'phone' => '081234567890',
                'address' => 'Demo Address',
                'company_name' => 'Demo Company'
            ]);
        }        // Create demo orders
        $timestamp = now()->format('YmdHis');
        $orders = [
            [
                'order_id' => 'ORD' . $timestamp . '001',
                'user_id' => $importer->user_id,
                'invoice_code' => 'INV' . $timestamp . '001',
                'tracking_number' => 'TG' . $timestamp . '001',
                'total_amount' => 150.00,
                'currency' => 'USD',
                'status' => 'paid',
                'shipping_status' => 'processing',
                'payment_status' => 'paid',
                'name' => $importer->name,
                'email' => $importer->email,
                'phone' => $importer->phone ?? '081234567890',
                'address' => 'Jl. Demo No. 123',
                'city' => 'Jakarta',
                'state' => 'DKI Jakarta',
                'zip_code' => '12345',
                'country' => 'Indonesia',
                'payment_method' => 'midtrans',
                'cart_items' => [
                    [
                        'product_id' => 1,
                        'product_name' => 'Kopi Arabica Premium',
                        'product_image' => 'kopi-arabica.jpg',
                        'price' => 25.00,
                        'quantity' => 4,
                        'weight' => 2.5
                    ],
                    [
                        'product_id' => 2,
                        'product_name' => 'Teh Hijau Organik',
                        'product_image' => 'teh-hijau.jpg',
                        'price' => 30.00,
                        'quantity' => 2,
                        'weight' => 1.5
                    ]
                ],
                'subtotal' => 125.00,
                'shipping_cost' => 25.00,
                'tax_amount' => 0.00,
                'discount_amount' => 0.00,
                'payment_completed_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],            [
                'order_id' => 'ORD' . $timestamp . '002',
                'user_id' => $importer->user_id,
                'invoice_code' => 'INV' . $timestamp . '002',
                'tracking_number' => 'TG' . $timestamp . '002',
                'total_amount' => 200.00,
                'currency' => 'USD',
                'status' => 'paid',
                'shipping_status' => 'shipped',
                'payment_status' => 'paid',
                'name' => $importer->name,
                'email' => $importer->email,
                'phone' => $importer->phone ?? '081234567890',
                'address' => 'Jl. Demo No. 456',
                'city' => 'Surabaya',
                'state' => 'Jawa Timur',
                'zip_code' => '54321',
                'country' => 'Indonesia',
                'payment_method' => 'midtrans',
                'cart_items' => [
                    [
                        'product_id' => 3,
                        'product_name' => 'Rempah-rempah Mix',
                        'product_image' => 'rempah-mix.jpg',
                        'price' => 45.00,
                        'quantity' => 3,
                        'weight' => 1.8
                    ],
                    [
                        'product_id' => 4,
                        'product_name' => 'Cokelat Premium',
                        'product_image' => 'cokelat.jpg',
                        'price' => 50.00,
                        'quantity' => 2,
                        'weight' => 2.0
                    ]
                ],
                'subtotal' => 175.00,
                'shipping_cost' => 25.00,
                'tax_amount' => 0.00,
                'discount_amount' => 0.00,
                'payment_completed_at' => now()->subHours(24),
                'created_at' => now()->subHours(24),
                'updated_at' => now()->subHours(24)
            ],
            [
                'order_id' => 'ORD' . now()->format('YmdHis') . '003',
                'user_id' => $importer->user_id,
                'total_amount' => 100.00,
                'currency' => 'USD',
                'status' => 'pending',
                'shipping_status' => 'pending',
                'payment_status' => 'pending',
                'name' => $importer->name,
                'email' => $importer->email,
                'phone' => $importer->phone ?? '081234567890',
                'address' => 'Jl. Demo No. 789',
                'city' => 'Bandung',
                'state' => 'Jawa Barat',
                'zip_code' => '98765',
                'country' => 'Indonesia',
                'payment_method' => 'midtrans',
                'cart_items' => [
                    [
                        'product_id' => 5,
                        'product_name' => 'Kopi Robusta',
                        'product_image' => 'kopi-robusta.jpg',
                        'price' => 20.00,
                        'quantity' => 3,
                        'weight' => 1.5
                    ]
                ],
                'subtotal' => 75.00,
                'shipping_cost' => 25.00,
                'tax_amount' => 0.00,
                'discount_amount' => 0.00,
                'payment_completed_at' => null,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2)            ],            [
                'order_id' => 'ORD' . $timestamp . '003',
                'user_id' => $importer->user_id,
                'invoice_code' => 'INV' . $timestamp . '003',
                'tracking_number' => null,
                'total_amount' => 120.00,
                'currency' => 'USD',
                'status' => 'pending',
                'shipping_status' => 'pending',
                'payment_status' => 'pending',
                'name' => $importer->name,
                'email' => $importer->email,
                'phone' => $importer->phone ?? '081234567890',
                'address' => 'Jl. Demo No. 789',
                'city' => 'Bandung',
                'state' => 'Jawa Barat',
                'zip_code' => '40123',
                'country' => 'Indonesia',
                'payment_method' => 'midtrans',
                'cart_items' => [
                    [
                        'product_id' => 5,
                        'product_name' => 'Kerupuk Premium',
                        'product_image' => 'kerupuk.jpg',
                        'price' => 15.00,
                        'quantity' => 3,
                        'weight' => 1.2
                    ],
                    [
                        'product_id' => 6,
                        'product_name' => 'Kacang Mete Premium',
                        'product_image' => 'kacang-mete.jpg',
                        'price' => 35.00,
                        'quantity' => 2,
                        'weight' => 1.8
                    ]
                ],
                'subtotal' => 115.00,
                'shipping_cost' => 5.00,
                'tax_amount' => 0.00,
                'discount_amount' => 0.00,
                'payment_completed_at' => null,
                'created_at' => now()->subHours(12),
                'updated_at' => now()->subHours(12)
            ]
        ];

        foreach ($orders as $orderData) {
            CheckoutOrder::create($orderData);
        }

        $this->command->info('Demo orders created successfully!');
    }
}
