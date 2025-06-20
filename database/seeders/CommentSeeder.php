<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get all approved products and all importers
        $products = Product::where('status', 'approved')->get();
        $importers = User::where('role', 'impor')->get();

        if ($products->isEmpty()) {
            $this->command->error('No approved products found! Please run ProductSeeder first.');
            return;
        }

        if ($importers->isEmpty()) {
            $this->command->error('No importers found! Please run UserSeeder first.');
            return;
        }

        // ✅ REALISTIC COMMENT TEMPLATES BY CATEGORY
        $commentTemplates = [
            'Food & Beverages' => [
                [
                    'comment' => 'Excellent quality! The taste is authentic and fresh. My customers love this product. Will definitely order again.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Good product but shipping took longer than expected. Quality is as described, packaging was secure.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Amazing flavor profile! Perfect for our restaurant chain. The supplier was very professional and responsive.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Great value for money. The product quality exceeded our expectations. Fast shipping and good communication.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Perfect for retail! Our customers are asking for more. The packaging is attractive and product is fresh.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Good quality but the price is a bit high compared to other suppliers. Overall satisfied with the purchase.',
                    'rating' => 3
                ],
                [
                    'comment' => 'Outstanding product! We have been ordering for 6 months now. Consistent quality and reliable supplier.',
                    'rating' => 5
                ],
                [
                    'comment' => 'The taste is very authentic. Perfect for our international grocery store. Customers love the quality.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Decent product but could improve packaging. Some items were damaged during shipping.',
                    'rating' => 3
                ],
                [
                    'comment' => 'Fantastic! This is exactly what we were looking for. Premium quality at reasonable price.',
                    'rating' => 5
                ]
            ],
            'Textile goods' => [
                [
                    'comment' => 'Beautiful fabric quality! The colors are vibrant and the texture is perfect for our fashion line.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Good material but the delivery was delayed. Quality matches the description perfectly.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Excellent craftsmanship! Our customers appreciate the traditional patterns and premium feel.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Great for wholesale. The fabric quality is consistent and the supplier is reliable.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Perfect texture and durability. We use this for our high-end clothing collection.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Good quality but expected better finishing. Overall satisfied with the purchase.',
                    'rating' => 3
                ],
                [
                    'comment' => 'Amazing! The fabric feels luxurious and the colors are exactly as shown in photos.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Decent quality for the price. Would recommend for mid-range fashion products.',
                    'rating' => 4
                ],
                [
                    'comment' => 'The fabric is beautiful but had some minor defects. Customer service was helpful.',
                    'rating' => 3
                ],
                [
                    'comment' => 'Exceptional quality! This supplier has become our preferred partner for textile sourcing.',
                    'rating' => 5
                ]
            ],
            'Furniture items' => [
                [
                    'comment' => 'Superb craftsmanship! The furniture is solid, beautiful, and exactly as described. Highly recommend!',
                    'rating' => 5
                ],
                [
                    'comment' => 'Good quality furniture but assembly instructions could be clearer. Overall very satisfied.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Excellent design and build quality. Our showroom customers are impressed with the craftsmanship.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Great value for money. The furniture is sturdy and the finish is professional.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Beautiful pieces! Perfect for our luxury hotel project. The wood quality is exceptional.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Good furniture but had some minor scratches upon delivery. Supplier offered compensation.',
                    'rating' => 3
                ],
                [
                    'comment' => 'Outstanding! The traditional design with modern functionality is exactly what we needed.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Quality furniture at competitive prices. Shipping was well-organized and secure.',
                    'rating' => 4
                ],
                [
                    'comment' => 'The furniture looks great but one piece arrived damaged. Customer service was responsive.',
                    'rating' => 3
                ],
                [
                    'comment' => 'Perfect for our interior design projects! Clients love the unique craftsmanship and quality.',
                    'rating' => 5
                ]
            ],
            'Electronics' => [
                [
                    'comment' => 'High-quality components! Perfect specifications and excellent performance. Will order more.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Good electronics but delivery was slower than expected. Quality meets international standards.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Excellent supplier! Components are reliable and pricing is competitive for bulk orders.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Great quality control. All components tested perfectly and documentation was complete.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Perfect for our manufacturing needs. Consistent quality and reliable supply chain.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Good components but packaging could be improved. Some items were loose in the box.',
                    'rating' => 3
                ],
                [
                    'comment' => 'Outstanding quality! These components have reduced our defect rate significantly.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Reliable supplier with good technical support. Components work perfectly in our products.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Decent quality but had compatibility issues with some components. Support helped resolve.',
                    'rating' => 3
                ],
                [
                    'comment' => 'Excellent! Best supplier we have worked with. Quality, price, and service are all top-notch.',
                    'rating' => 5
                ]
            ],
            'Raw materials' => [
                [
                    'comment' => 'Excellent raw material quality! Consistent grade and purity. Our production runs smoothly.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Good material but delivery schedule needs improvement. Quality is as specified.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Perfect for industrial use! High purity and consistent quality. Reliable supplier.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Great bulk pricing and quality. Materials meet all our technical specifications.',
                    'rating' => 4
                ],
                [
                    'comment' => 'Outstanding material quality! Zero defects and excellent packaging for safe transport.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Good materials but had some contamination issues. Supplier provided replacement quickly.',
                    'rating' => 3
                ],
                [
                    'comment' => 'Excellent supplier! Materials are top-grade and delivery is always on schedule.',
                    'rating' => 5
                ],
                [
                    'comment' => 'Quality materials at competitive prices. Perfect for our manufacturing requirements.',
                    'rating' => 4
                ],
                [
                    'comment' => 'The material quality varies slightly between batches. Overall acceptable for our use.',
                    'rating' => 3
                ],
                [
                    'comment' => 'Premium quality materials! Our finished products have improved significantly since switching.',
                    'rating' => 5
                ]
            ]
        ];

        $totalComments = 0;

        // ✅ CREATE COMMENTS FOR EACH PRODUCT
        foreach ($products as $product) {
            $this->command->info("💬 Creating comments for: {$product->product_name}");

            // Random number of comments per product (3-5)
            $commentCount = rand(3, 5);
            
            // Get random importers for this product (ensure variety)
            $selectedImporters = $importers->random(min($commentCount, $importers->count()));
            
            // Get appropriate comment templates for this product category
            $categoryTemplates = $commentTemplates[$product->category] ?? $commentTemplates['Food & Beverages'];
            
            $productComments = 0;
            
            foreach ($selectedImporters as $index => $importer) {
                if ($productComments >= $commentCount) break;
                
                // Select random comment template
                $template = $categoryTemplates[array_rand($categoryTemplates)];
                
                // Add some variation to ratings (mostly positive)
                $baseRating = $template['rating'];
                $ratingVariation = rand(-1, 1);
                $finalRating = max(1, min(5, $baseRating + $ratingVariation));
                
                // Create realistic timestamps (comments from last 6 months)
                $createdAt = now()->subDays(rand(1, 180))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
                
                try {
                    Comment::create([
                        'product_id' => $product->product_id,
                        'user_id' => $importer->user_id,
                        'comment_text' => $template['comment'],
                        'rating' => $finalRating,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);

                    $productComments++;
                    $totalComments++;
                    
                    $stars = str_repeat('⭐', $finalRating);
                    $this->command->info("  ✅ {$importer->name} ({$importer->country}): {$stars}");
                    
                } catch (\Exception $e) {
                    $this->command->error("  ❌ Error creating comment: " . $e->getMessage());
                    continue;
                }
            }
            
            $this->command->info("  📊 Total comments for this product: {$productComments}");
        }

        // ✅ CALCULATE STATISTICS
        $totalProducts = $products->count();
        $averageCommentsPerProduct = round($totalComments / $totalProducts, 1);
        $ratingStats = Comment::selectRaw('
            AVG(rating) as avg_rating,
            COUNT(CASE WHEN rating = 5 THEN 1 END) as five_star,
            COUNT(CASE WHEN rating = 4 THEN 1 END) as four_star,
            COUNT(CASE WHEN rating = 3 THEN 1 END) as three_star,
            COUNT(CASE WHEN rating = 2 THEN 1 END) as two_star,
            COUNT(CASE WHEN rating = 1 THEN 1 END) as one_star
        ')->first();

        // ✅ DISPLAY FINAL STATISTICS
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("🎉 COMMENTS SEEDING COMPLETED SUCCESSFULLY! 🎉");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("📦 Total Products: {$totalProducts}");
        $this->command->info("💬 Total Comments Created: {$totalComments}");
        $this->command->info("📊 Average Comments per Product: {$averageCommentsPerProduct}");
        $this->command->info("⭐ Average Rating: " . round($ratingStats->avg_rating, 2) . "/5");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("📈 RATING DISTRIBUTION:");
        $this->command->info("   ⭐⭐⭐⭐⭐ 5 Stars: {$ratingStats->five_star}");
        $this->command->info("   ⭐⭐⭐⭐ 4 Stars: {$ratingStats->four_star}");
        $this->command->info("   ⭐⭐⭐ 3 Stars: {$ratingStats->three_star}");
        $this->command->info("   ⭐⭐ 2 Stars: {$ratingStats->two_star}");
        $this->command->info("   ⭐ 1 Star: {$ratingStats->one_star}");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        
        // ✅ TOP COMMENTED PRODUCTS
        $topCommentedProducts = Product::withCount('comments')
                                      ->orderBy('comments_count', 'desc')
                                      ->limit(5)
                                      ->get();
        
        $this->command->info("🏆 TOP 5 MOST COMMENTED PRODUCTS:");
        foreach ($topCommentedProducts as $index => $product) {
            $rank = $index + 1;
            $avgRating = $product->comments()->avg('rating');
            $avgRatingFormatted = $avgRating ? round($avgRating, 1) : 'N/A';
            $this->command->info("   {$rank}. {$product->product_name} ({$product->comments_count} comments, {$avgRatingFormatted}⭐)");
        }
        
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("🚀 Comments ready! Products now have realistic customer reviews from importers.");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
    }
}