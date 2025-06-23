<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Product;

class ProductStockChart extends ChartWidget
{    protected static ?string $heading = 'Numbers of Products by Stock Ranges';
    
    protected static ?int $sort = 11;

    protected int | string | array $columnSpan = 12;

    protected function getData(): array
    {
        // Group products by stock ranges
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
                    'label' => 'Products Count',
                    'data' => array_values($stockRanges),
                    'backgroundColor' => [
                        '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FECA57'
                    ],
                    'borderColor' => [
                        '#FF5252', '#26C6DA', '#2196F3', '#66BB6A', '#FFC107'
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => array_keys($stockRanges),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
