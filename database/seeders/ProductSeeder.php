<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get all users dengan role ekspor
        $exporters = User::where('role', 'ekspor')->get();

        if ($exporters->isEmpty()) {
            $this->command->error('No exporters found! Please run UserSeeder first.');
            return;
        }

        $productTemplates = [
            // Indonesia Products
            [
                'product_name' => 'Premium Java Coffee Beans',
                'product_description' => 'High-quality arabica coffee beans sourced from the volcanic mountains of Java. Single-origin beans with rich, full-bodied flavor perfect for specialty coffee shops and discerning coffee lovers.',
                'category' => 'Food & Beverages',
                'price' => 28.50,
                'stock_quantity' => 500,
                'weight' => 1.0,
                'image_url' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Handwoven Batik Fabric',
                'product_description' => 'Traditional handwoven batik fabric with intricate Javanese patterns. Made by skilled artisans using traditional wax-resist dyeing techniques passed down through generations.',
                'category' => 'Textile goods',
                'price' => 45.00,
                'stock_quantity' => 200,
                'weight' => 0.5,
                'image_url' => 'https://images.unsplash.com/photo-1594736797933-d0cc3d0d5368?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Premium Teak Wood Furniture',
                'product_description' => 'Handcrafted teak wood dining table made from sustainably sourced Indonesian teak. Features natural grain patterns and exceptional durability perfect for modern homes.',
                'category' => 'Furniture items',
                'price' => 850.00,
                'stock_quantity' => 25,
                'weight' => 45.0,
                'image_url' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Natural Rubber Sheets',
                'product_description' => 'High-grade natural rubber sheets suitable for industrial applications. Sourced from sustainable rubber plantations in Sumatra with excellent elasticity and durability.',
                'category' => 'Raw materials',
                'price' => 12.75,
                'stock_quantity' => 1000,
                'weight' => 2.5,
                'image_url' => 'https://images.unsplash.com/photo-1582719188393-bb71ca45dbb9?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Virgin Coconut Oil',
                'product_description' => 'Extra virgin organic coconut oil extracted using traditional cold-press methods. Perfect for cooking, cosmetics, and health applications with natural coconut aroma.',
                'category' => 'Food & Beverages',
                'price' => 22.50,
                'stock_quantity' => 300,
                'weight' => 1.2,
                'image_url' => 'https://images.unsplash.com/photo-1576635513317-8b6b2b3b1e5d?w=500&h=400&fit=crop',
            ],

            // Philippines Products
            [
                'product_name' => 'Dried Tropical Mangoes',
                'product_description' => 'Sweet and chewy dried mango strips made from premium Philippine mangoes. No artificial preservatives, perfect healthy snack rich in vitamins and minerals.',
                'category' => 'Food & Beverages',
                'price' => 15.75,
                'stock_quantity' => 400,
                'weight' => 0.8,
                'image_url' => 'https://images.unsplash.com/photo-1553279755-2ddd933c8d1d?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Handmade Rattan Furniture',
                'product_description' => 'Eco-friendly rattan chair handwoven by Filipino artisans. Lightweight, durable, and perfect for both indoor and outdoor use with natural water resistance.',
                'category' => 'Furniture items',
                'price' => 120.00,
                'stock_quantity' => 80,
                'weight' => 8.5,
                'image_url' => 'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Philippine Sea Salt',
                'product_description' => 'Premium sea salt harvested from pristine Philippine waters. Unrefined and mineral-rich, perfect for gourmet cooking and food preservation.',
                'category' => 'Food & Beverages',
                'price' => 8.25,
                'stock_quantity' => 600,
                'weight' => 2.0,
                'image_url' => 'https://images.unsplash.com/photo-1528740561666-dc2479dc08ab?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Bamboo Textiles',
                'product_description' => 'Soft and breathable bamboo fabric made from Philippine bamboo. Naturally antibacterial and moisture-wicking, perfect for sustainable fashion.',
                'category' => 'Textile goods',
                'price' => 35.00,
                'stock_quantity' => 150,
                'weight' => 0.6,
                'image_url' => 'https://images.unsplash.com/photo-1552346989-e069318e20a1?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Electronics Components',
                'product_description' => 'High-quality electronic components including microprocessors, resistors, and capacitors. Manufactured to international standards for electronic devices.',
                'category' => 'Electronics',
                'price' => 65.00,
                'stock_quantity' => 250,
                'weight' => 1.5,
                'image_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=500&h=400&fit=crop',
            ],

            // Thailand Products
            [
                'product_name' => 'Thai Jasmine Rice',
                'product_description' => 'Premium Thai Hom Mali jasmine rice with natural fragrance and soft texture. Grade A quality rice perfect for Asian cuisine and international markets.',
                'category' => 'Food & Beverages',
                'price' => 18.00,
                'stock_quantity' => 800,
                'weight' => 25.0,
                'image_url' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Thai Silk Fabric',
                'product_description' => 'Luxurious Thai silk fabric with traditional patterns and vibrant colors. Handwoven by skilled artisans in Northeast Thailand with centuries-old techniques.',
                'category' => 'Textile goods',
                'price' => 75.00,
                'stock_quantity' => 100,
                'weight' => 0.4,
                'image_url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Thai Ceramic Pottery',
                'product_description' => 'Traditional Thai ceramic vases and bowls with intricate designs. Handcrafted using traditional techniques, perfect for home decoration and gift items.',
                'category' => 'Furniture items',
                'price' => 42.00,
                'stock_quantity' => 120,
                'weight' => 3.2,
                'image_url' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Natural Latex Products',
                'product_description' => 'Premium natural latex foam and mattresses from Thai rubber trees. Hypoallergenic and durable, perfect for comfortable and healthy sleep.',
                'category' => 'Raw materials',
                'price' => 95.00,
                'stock_quantity' => 60,
                'weight' => 12.0,
                'image_url' => 'https://images.unsplash.com/photo-1541558869434-2840d308329a?w=500&h=400&fit=crop',
            ],
            [
                'product_name' => 'Thai Spices Mix',
                'product_description' => 'Authentic Thai spice blend including lemongrass, galangal, and kaffir lime leaves. Perfect for creating traditional Thai dishes with authentic flavors.',
                'category' => 'Food & Beverages',
                'price' => 25.00,
                'stock_quantity' => 350,
                'weight' => 0.5,
                'image_url' => 'https://images.unsplash.com/photo-1596040033229-a1a03c0de8f3?w=500&h=400&fit=crop',
            ],
        ];

        $productIndex = 0;
        
        foreach ($exporters as $exporterIndex => $exporter) {
            $this->command->info("Creating products for {$exporter->name} from {$exporter->country}...");

            try {
                // Create 5 products per exporter
                for ($i = 0; $i < 5; $i++) {
                    $template = $productTemplates[$productIndex % count($productTemplates)];
                    
                    // Status distribution: 4 approved, 1 pending per exporter
                    $status = ($i == 0) ? 'pending' : 'approved';
                    
                    // Add variation to prices and quantities
                    $priceVariation = rand(-1000, 1000) / 100; // ±$10.00 variation
                    $quantityVariation = rand(-50, 100); // quantity variation
                    
                    $product = Product::create([
                        'user_id' => $exporter->user_id,
                        'product_name' => $template['product_name'] ,
                        'product_description' => $template['product_description'],
                        'category' => $template['category'],
                        'price' => max(1.00, round($template['price'] + $priceVariation, 2)),
                        'stock_quantity' => max(1, $template['stock_quantity'] + $quantityVariation),
                        'weight' => round(max(0.1, $template['weight'] + rand(-50, 50) / 100), 2),
                        'country_of_origin' => $exporter->country,
                        'product_image' => $template['image_url'],
                        'status' => $status,
                    ]);

                    $statusIcon = $status == 'approved' ? '✅' : '⏳';
                    $this->command->info("  {$statusIcon} Created: " . $product->product_name . " (SKU: " . $product->product_sku . ")");
                    
                    $productIndex++;
                }

                $this->command->info("✅ Created 5 products for " . $exporter->name . " (1 pending, 4 approved)");
                
            } catch (\Exception $e) {
                $this->command->error("❌ Error creating products for " . $exporter->name . ": " . $e->getMessage());
                continue;
            }
        }

        // Display final statistics
        $totalProducts = Product::count();
        $pendingProducts = Product::where('status', 'pending')->count();
        $approvedProducts = Product::where('status', 'approved')->count();
        $totalExporters = $exporters->count();

        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("✅ Products seeding completed successfully!");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("👥 Total Exporters: " . $totalExporters);
        $this->command->info("📦 Total Products: " . $totalProducts);
        $this->command->info("✅ Approved Products: " . $approvedProducts . " (" . round(($approvedProducts/$totalProducts)*100, 1) . "%)");
        $this->command->info("⏳ Pending Products: " . $pendingProducts . " (" . round(($pendingProducts/$totalProducts)*100, 1) . "%)");
        $this->command->info("🖼️  Products with Images: " . $totalProducts . " (100%)");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        
        // Show products by country
        $this->command->info("📊 Products by Country:");
        foreach($exporters as $exporter) {
            $countryProducts = Product::whereHas('user', function($q) use ($exporter) {
                $q->where('country', $exporter->country);
            })->count();
            $this->command->info("   🌏 {$exporter->country}: {$countryProducts} products");
        }
    }
}