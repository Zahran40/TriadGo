<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\DB;

class ProductsByCategoryChart extends ChartWidget
{    protected static ?string $heading = 'Produk Sering Dibeli Berdasarkan Kategori';
    
    protected static ?int $sort = 10;
    protected int | string | array $columnSpan = 12;

    protected function getData(): array
    {        // Get most purchased products by category from checkout orders
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
                    // Get category from product ID if available
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
            ->take(10)
            ->values();

        // If no order data, get from products directly
        if ($categoryData->isEmpty()) {
            $categoryData = \App\Models\Product::select('category', DB::raw('count(*) as total_quantity'))
                ->where('status', 'approved')
                ->groupBy('category')
                ->orderByDesc('total_quantity')
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'category' => $item->category,
                        'total_quantity' => $item->total_quantity
                    ];
                });
        }

        $labels = $categoryData->pluck('category')->toArray();
        $data = $categoryData->pluck('total_quantity')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Dibeli',
                    'data' => $data,
                    'backgroundColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
                        '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF',
                        '#4BC0C0', '#FF6384'
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
