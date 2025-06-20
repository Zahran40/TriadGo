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

        // ✅ PRODUCT TEMPLATES - 60+ Products with Real Images
        $productTemplates = [
            // 🇮🇩 INDONESIA PRODUCTS (15 products)
            [
                'product_name' => 'Premium Java Coffee Beans',
                'product_description' => 'High-quality arabica coffee beans sourced from the volcanic mountains of Java. Single-origin beans with rich, full-bodied flavor perfect for specialty coffee shops.',
                'category' => 'Food & Beverages',
                'price' => 28.50,
                'stock_quantity' => 500,
                'weight' => 1.0,
                'image_url' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Handwoven Batik Fabric',
                'product_description' => 'Traditional handwoven batik fabric with intricate Javanese patterns. Made by skilled artisans using traditional wax-resist dyeing techniques.',
                'category' => 'Textile goods',
                'price' => 45.00,
                'stock_quantity' => 200,
                'weight' => 0.5,
                'image_url' => 'https://images.unsplash.com/photo-1594736797933-d0cc3d0d5368?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Premium Teak Wood Furniture',
                'product_description' => 'Handcrafted teak wood dining table made from sustainably sourced Indonesian teak. Features natural grain patterns and exceptional durability.',
                'category' => 'Furniture items',
                'price' => 850.00,
                'stock_quantity' => 25,
                'weight' => 45.0,
                'image_url' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Natural Rubber Sheets',
                'product_description' => 'High-grade natural rubber sheets suitable for industrial applications. Sourced from sustainable rubber plantations in Sumatra.',
                'category' => 'Raw materials',
                'price' => 12.75,
                'stock_quantity' => 1000,
                'weight' => 2.5,
                'image_url' => 'https://images.unsplash.com/photo-1582719188393-bb71ca45dbb9?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Virgin Coconut Oil',
                'product_description' => 'Extra virgin organic coconut oil extracted using traditional cold-press methods. Perfect for cooking, cosmetics, and health applications.',
                'category' => 'Food & Beverages',
                'price' => 22.50,
                'stock_quantity' => 300,
                'weight' => 1.2,
                'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Indonesian Vanilla Beans',
                'product_description' => 'Premium grade A vanilla beans from Indonesian plantations. Rich, complex flavor profile perfect for baking and gourmet culinary applications.',
                'category' => 'Food & Beverages',
                'price' => 85.00,
                'stock_quantity' => 150,
                'weight' => 0.3,
                'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Handcrafted Rattan Baskets',
                'product_description' => 'Traditional Indonesian rattan baskets handwoven by local artisans. Durable, eco-friendly, and perfect for home organization.',
                'category' => 'Furniture items',
                'price' => 35.00,
                'stock_quantity' => 180,
                'weight' => 2.0,
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Indonesian Clove Spice',
                'product_description' => 'Aromatic Indonesian cloves harvested from Maluku islands. High oil content and intense flavor, perfect for culinary applications.',
                'category' => 'Food & Beverages',
                'price' => 18.75,
                'stock_quantity' => 400,
                'weight' => 0.8,
                'image_url' => 'https://images.unsplash.com/photo-1596040033229-a1a03c0de8f3?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Indonesian Palm Sugar',
                'product_description' => 'Organic palm sugar tapped from coconut palm trees. Natural sweetener with low glycemic index and rich caramel flavor.',
                'category' => 'Food & Beverages',
                'price' => 16.50,
                'stock_quantity' => 350,
                'weight' => 1.5,
                'image_url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Indonesian Cashew Nuts',
                'product_description' => 'Premium grade cashew nuts from Indonesian plantations. Carefully processed and roasted to perfection, rich in healthy fats.',
                'category' => 'Food & Beverages',
                'price' => 32.50,
                'stock_quantity' => 450,
                'weight' => 1.8,
                'image_url' => 'https://images.unsplash.com/photo-1553279755-2ddd933c8d1d?w=800&h=600&fit=crop&crop=center',
            ],

            // 🇵🇭 PHILIPPINES PRODUCTS (15 products)
            [
                'product_name' => 'Dried Tropical Mangoes',
                'product_description' => 'Sweet and chewy dried mango strips made from premium Philippine mangoes. No artificial preservatives, perfect healthy snack.',
                'category' => 'Food & Beverages',
                'price' => 15.75,
                'stock_quantity' => 400,
                'weight' => 0.8,
                'image_url' => 'https://images.unsplash.com/photo-1553279755-2ddd933c8d1d?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Handmade Rattan Furniture',
                'product_description' => 'Eco-friendly rattan chair handwoven by Filipino artisans. Lightweight, durable, and perfect for both indoor and outdoor use.',
                'category' => 'Furniture items',
                'price' => 120.00,
                'stock_quantity' => 80,
                'weight' => 8.5,
                'image_url' => 'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Philippine Sea Salt',
                'product_description' => 'Premium sea salt harvested from pristine Philippine waters. Unrefined and mineral-rich, perfect for gourmet cooking.',
                'category' => 'Food & Beverages',
                'price' => 8.25,
                'stock_quantity' => 600,
                'weight' => 2.0,
                'image_url' => 'https://images.unsplash.com/photo-1528740561666-dc2479dc08ab?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Electronics Components',
                'product_description' => 'High-quality electronic components including microprocessors, resistors, and capacitors. Manufactured to international standards.',
                'category' => 'Electronics',
                'price' => 65.00,
                'stock_quantity' => 250,
                'weight' => 1.5,
                'image_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Philippine Coconut Products',
                'product_description' => 'Various coconut products including coconut flour, coconut milk powder, and desiccated coconut. Organic and sustainably sourced.',
                'category' => 'Food & Beverages',
                'price' => 19.50,
                'stock_quantity' => 320,
                'weight' => 1.0,
                'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Philippine Banana Chips',
                'product_description' => 'Crispy banana chips made from Philippine saba bananas. Naturally sweet and crunchy, perfect healthy snack for all ages.',
                'category' => 'Food & Beverages',
                'price' => 14.25,
                'stock_quantity' => 450,
                'weight' => 0.9,
                'image_url' => 'https://images.unsplash.com/photo-1553279755-2ddd933c8d1d?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Cebu Furniture Sets',
                'product_description' => 'Modern furniture sets manufactured in Cebu. High-quality materials and craftsmanship with contemporary design.',
                'category' => 'Furniture items',
                'price' => 420.00,
                'stock_quantity' => 30,
                'weight' => 35.0,
                'image_url' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Philippine Processed Foods',
                'product_description' => 'Variety of processed foods including corned beef, sardines, and instant noodles. Popular Filipino brands with international quality.',
                'category' => 'Food & Beverages',
                'price' => 25.50,
                'stock_quantity' => 300,
                'weight' => 2.5,
                'image_url' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Bamboo Textiles',
                'product_description' => 'Soft and breathable bamboo fabric made from Philippine bamboo. Naturally antibacterial and moisture-wicking.',
                'category' => 'Textile goods',
                'price' => 35.00,
                'stock_quantity' => 150,
                'weight' => 0.6,
                'image_url' => 'https://images.unsplash.com/photo-1552346989-e069318e20a1?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Philippine Pearls',
                'product_description' => 'Cultured South Sea pearls from Philippine waters. High luster and round shape, perfect for jewelry making.',
                'category' => 'Raw materials',
                'price' => 180.00,
                'stock_quantity' => 50,
                'weight' => 0.2,
                'image_url' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=800&h=600&fit=crop&crop=center',
            ],

            // 🇹🇭 THAILAND PRODUCTS (15 products)
            [
                'product_name' => 'Thai Jasmine Rice',
                'product_description' => 'Premium Thai Hom Mali jasmine rice with natural fragrance and soft texture. Grade A quality rice perfect for Asian cuisine.',
                'category' => 'Food & Beverages',
                'price' => 18.00,
                'stock_quantity' => 800,
                'weight' => 25.0,
                'image_url' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Thai Silk Fabric',
                'product_description' => 'Luxurious Thai silk fabric with traditional patterns and vibrant colors. Handwoven by skilled artisans in Northeast Thailand.',
                'category' => 'Textile goods',
                'price' => 75.00,
                'stock_quantity' => 100,
                'weight' => 0.4,
                'image_url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Thai Teak Furniture',
                'product_description' => 'Premium teak furniture from sustainable Thai plantations. Traditional craftsmanship meets modern design.',
                'category' => 'Furniture items',
                'price' => 680.00,
                'stock_quantity' => 35,
                'weight' => 50.0,
                'image_url' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Natural Latex Products',
                'product_description' => 'Premium natural latex foam and mattresses from Thai rubber trees. Hypoallergenic and durable for comfortable sleep.',
                'category' => 'Raw materials',
                'price' => 95.00,
                'stock_quantity' => 60,
                'weight' => 12.0,
                'image_url' => 'https://images.unsplash.com/photo-1541558869434-2840d308329a?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Thai Spices Mix',
                'product_description' => 'Authentic Thai spice blend including lemongrass, galangal, and kaffir lime leaves. Perfect for traditional Thai dishes.',
                'category' => 'Food & Beverages',
                'price' => 25.00,
                'stock_quantity' => 350,
                'weight' => 0.5,
                'image_url' => 'https://images.unsplash.com/photo-1596040033229-a1a03c0de8f3?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Thai Fish Sauce',
                'product_description' => 'Premium Thai fish sauce made from anchovy extract. Essential ingredient for authentic Thai cuisine with umami-rich flavor.',
                'category' => 'Food & Beverages',
                'price' => 16.75,
                'stock_quantity' => 420,
                'weight' => 1.5,
                'image_url' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Thai Instant Noodles',
                'product_description' => 'World-famous Thai instant noodles with authentic tom yum and pad thai flavors. Popular international snack food.',
                'category' => 'Food & Beverages',
                'price' => 12.50,
                'stock_quantity' => 600,
                'weight' => 0.6,
                'image_url' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Thai Automotive Parts',
                'product_description' => 'High-quality automotive components manufactured in Thailand. Parts for various vehicle makes and models.',
                'category' => 'Electronics',
                'price' => 125.00,
                'stock_quantity' => 200,
                'weight' => 8.5,
                'image_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Thai Dried Fruits',
                'product_description' => 'Assorted dried tropical fruits including mango, pineapple, and papaya. Natural sweetness with no artificial preservatives.',
                'category' => 'Food & Beverages',
                'price' => 22.75,
                'stock_quantity' => 380,
                'weight' => 1.2,
                'image_url' => 'https://images.unsplash.com/photo-1553279755-2ddd933c8d1d?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Thai Tapioca Starch',
                'product_description' => 'High-quality tapioca starch from Thai cassava roots. Food-grade starch perfect for food processing and industrial applications.',
                'category' => 'Raw materials',
                'price' => 15.25,
                'stock_quantity' => 700,
                'weight' => 5.0,
                'image_url' => 'https://images.unsplash.com/photo-1582719188393-bb71ca45dbb9?w=800&h=600&fit=crop&crop=center',
            ],

            // 🇻🇳 VIETNAM PRODUCTS (10 products)
            [
                'product_name' => 'Vietnamese Coffee Beans',
                'product_description' => 'Premium Vietnamese robusta coffee beans with bold, strong flavor. Perfect for espresso and traditional Vietnamese coffee.',
                'category' => 'Food & Beverages',
                'price' => 24.00,
                'stock_quantity' => 450,
                'weight' => 1.0,
                'image_url' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Vietnamese Textiles',
                'product_description' => 'High-quality Vietnamese textile products including cotton fabrics and garments. Manufactured with modern technology.',
                'category' => 'Textile goods',
                'price' => 28.50,
                'stock_quantity' => 320,
                'weight' => 0.8,
                'image_url' => 'https://images.unsplash.com/photo-1552346989-e069318e20a1?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Vietnamese Cashew Nuts',
                'product_description' => 'Premium quality cashew nuts from Vietnamese plantations. Carefully processed and roasted to perfection.',
                'category' => 'Food & Beverages',
                'price' => 35.75,
                'stock_quantity' => 380,
                'weight' => 1.5,
                'image_url' => 'https://images.unsplash.com/photo-1553279755-2ddd933c8d1d?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Vietnamese Electronics',
                'product_description' => 'Electronic components and consumer electronics manufactured in Vietnam. High quality with competitive pricing.',
                'category' => 'Electronics',
                'price' => 85.00,
                'stock_quantity' => 220,
                'weight' => 2.2,
                'image_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Vietnamese Rice Products',
                'product_description' => 'Various Vietnamese rice products including jasmine rice, rice noodles, and rice paper. Staple foods with authentic quality.',
                'category' => 'Food & Beverages',
                'price' => 19.25,
                'stock_quantity' => 520,
                'weight' => 10.0,
                'image_url' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=800&h=600&fit=crop&crop=center',
            ],

            // 🇲🇾 MALAYSIA PRODUCTS (8 products)
            [
                'product_name' => 'Malaysian Palm Oil',
                'product_description' => 'High-quality refined palm oil from Malaysian plantations. Sustainable sourcing with RSPO certification.',
                'category' => 'Raw materials',
                'price' => 18.50,
                'stock_quantity' => 800,
                'weight' => 10.0,
                'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Malaysian Electronics',
                'product_description' => 'Advanced electronic components and semiconductors manufactured in Malaysia. High-tech products for global electronics.',
                'category' => 'Electronics',
                'price' => 145.00,
                'stock_quantity' => 180,
                'weight' => 1.8,
                'image_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Malaysian Tropical Fruits',
                'product_description' => 'Fresh and processed tropical fruits from Malaysia including durian, rambutan, and mangosteen. Exotic flavors.',
                'category' => 'Food & Beverages',
                'price' => 28.75,
                'stock_quantity' => 250,
                'weight' => 2.0,
                'image_url' => 'https://images.unsplash.com/photo-1553279755-2ddd933c8d1d?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Malaysian Rubber Gloves',
                'product_description' => 'World-class rubber gloves manufactured in Malaysia. Medical and industrial grade with superior quality.',
                'category' => 'Raw materials',
                'price' => 45.00,
                'stock_quantity' => 600,
                'weight' => 2.5,
                'image_url' => 'https://images.unsplash.com/photo-1582719188393-bb71ca45dbb9?w=800&h=600&fit=crop&crop=center',
            ],
            [
                'product_name' => 'Malaysian Processed Foods',
                'product_description' => 'Variety of Malaysian processed foods including instant noodles, biscuits, and snacks. Popular brands with halal certification.',
                'category' => 'Food & Beverages',
                'price' => 24.50,
                'stock_quantity' => 350,
                'weight' => 1.8,
                'image_url' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=800&h=600&fit=crop&crop=center',
            ],
        ];

        // ✅ DISTRIBUTION LOGIC
        $totalProducts = count($productTemplates);
        $productsPerExporter = ceil($totalProducts / $exporters->count());
        $productIndex = 0;

        foreach ($exporters as $exporter) {
            $this->command->info("🏭 Creating products for {$exporter->name} from {$exporter->country}...");

            $productsForThisExporter = min($productsPerExporter, $totalProducts - $productIndex);
            
            for ($i = 0; $i < $productsForThisExporter; $i++) {
                if ($productIndex >= $totalProducts) break;
                
                $template = $productTemplates[$productIndex];
                
                // ✅ STATUS DISTRIBUTION: 80% approved, 20% pending
                $status = (rand(1, 100) <= 80) ? 'approved' : 'pending';
                
                // Add variation to prices and quantities
                $priceVariation = rand(-500, 500) / 100;
                $quantityVariation = rand(-30, 50);
                
                Product::create([
                    'user_id' => $exporter->user_id,
                    'product_name' => $template['product_name'],
                    'product_description' => $template['product_description'],
                    'category' => $template['category'],
                    'price' => max(1.00, round($template['price'] + $priceVariation, 2)),
                    'stock_quantity' => max(1, $template['stock_quantity'] + $quantityVariation),
                    'weight' => round(max(0.1, $template['weight'] + rand(-20, 20) / 100), 2),
                    'country_of_origin' => $exporter->country,
                    'product_image' => $template['image_url'],
                    'status' => $status,
                ]);

                $productIndex++;
            }

            $approvedCount = Product::where('user_id', $exporter->user_id)->where('status', 'approved')->count();
            $pendingCount = Product::where('user_id', $exporter->user_id)->where('status', 'pending')->count();
            
            $this->command->info("✅ {$exporter->name}: {$productsForThisExporter} products ({$approvedCount} approved, {$pendingCount} pending)");
        }

        // ✅ FINAL STATISTICS
        $totalProductsCreated = Product::count();
        $pendingProducts = Product::where('status', 'pending')->count();
        $approvedProducts = Product::where('status', 'approved')->count();

        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("🎉 PRODUCTS SEEDING COMPLETED SUCCESSFULLY! 🎉");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("📦 Total Products Created: " . $totalProductsCreated);
        $this->command->info("✅ Approved Products: " . $approvedProducts . " (" . round(($approvedProducts/$totalProductsCreated)*100, 1) . "%)");
        $this->command->info("⏳ Pending Products: " . $pendingProducts . " (" . round(($pendingProducts/$totalProductsCreated)*100, 1) . "%)");
        $this->command->info("🖼️ Products with Images: " . $totalProductsCreated . " (100%)");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
    }
}