<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProductsByCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Products by Category';
    
    protected static ?int $sort = 3;

    // Half width — sits side by side with UserRoleDistribution
    protected int | string | array $columnSpan = 1;

    protected static bool $isLazy = true;
    protected static ?string $pollingInterval = '120s';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return Cache::remember('admin_products_by_category', 300, function () {
            // Get most purchased products by category from checkout orders
            $categoryData = CheckoutOrder::join('users', 'checkout_orders.user_id', '=', 'users.user_id')
                ->where('checkout_orders.status', '!=', 'failed')
                ->where('users.role', 'impor')
                ->get()->flatMap(function ($order) {
                    $cartItems = $order->cart_items;
                    if (is_string($cartItems)) {
                        $cartItems = json_decode($cartItems, true) ?? [];
                    } elseif (!is_array($cartItems)) {
                        $cartItems = [];
                    }
                    
                    return collect($cartItems)->map(function ($item) {
                        $product = \App\Models\Product::find($item['id'] ?? null);
                        return [
                            'category' => $product ? $product->category : ($item['category'] ?? 'Unknown'),
                            'quantity' => $item['quantity'] ?? 1
                        ];
                    });
                })
                ->groupBy('category')
                ->map(function ($items, $category) {
                    return [
                        'category' => $category,
                        'total_quantity' => $items->sum('quantity')
                    ];
                })
                ->sortByDesc('total_quantity')
                ->take(8)
                ->values();

            // Fallback: get from products if no orders
            if ($categoryData->isEmpty()) {
                $categoryData = \App\Models\Product::select('category', DB::raw('count(*) as total_quantity'))
                    ->where('status', 'approved')
                    ->groupBy('category')
                    ->orderByDesc('total_quantity')
                    ->take(8)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'category' => $item->category,
                            'total_quantity' => $item->total_quantity
                        ];
                    });
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Products',
                        'data' => $categoryData->pluck('total_quantity')->toArray(),
                        'backgroundColor' => [
                            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', 
                            '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'
                        ],
                        'borderWidth' => 0,
                    ],
                ],
                'labels' => $categoryData->pluck('category')->toArray(),
            ];
        });
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'padding' => 15,
                        'usePointStyle' => true,
                    ],
                ],
            ],
            'cutout' => '60%',
        ];
    }
}
