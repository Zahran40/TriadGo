<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductStockChart extends ChartWidget
{
    protected static ?string $heading = 'Products by Stock Range';
    
    protected static ?int $sort = 5;

    // Half width
    protected int | string | array $columnSpan = 1;

    protected static bool $isLazy = true;
    protected static ?string $pollingInterval = '120s';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return Cache::remember('admin_product_stock_chart', 300, function () {
            $stockRanges = [
                '0-10' => Product::where('stock_quantity', '>=', 0)->where('stock_quantity', '<=', 10)->count(),
                '11-50' => Product::where('stock_quantity', '>=', 11)->where('stock_quantity', '<=', 50)->count(),
                '51-100' => Product::where('stock_quantity', '>=', 51)->where('stock_quantity', '<=', 100)->count(),
                '101-500' => Product::where('stock_quantity', '>=', 101)->where('stock_quantity', '<=', 500)->count(),
                '500+' => Product::where('stock_quantity', '>', 500)->count(),
            ];

            return [
                'datasets' => [
                    [
                        'label' => 'Products',
                        'data' => array_values($stockRanges),
                        'backgroundColor' => [
                            '#EF4444', '#F59E0B', '#3B82F6', '#10B981', '#8B5CF6'
                        ],
                        'borderColor' => [
                            '#DC2626', '#D97706', '#2563EB', '#059669', '#7C3AED'
                        ],
                        'borderWidth' => 1,
                        'borderRadius' => 6,
                    ],
                ],
                'labels' => array_keys($stockRanges),
            ];
        });
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 5,
                    ],
                ],
            ],
        ];
    }
}
