<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Product;

class ProductWeightChart extends ChartWidget
{    protected static ?string $heading = 'Product Distribution by Weight (kg)';
    
    protected static ?int $sort = 12;

    protected int | string | array $columnSpan = 12;

    protected function getData(): array
    {
        // Group products by weight ranges
        $weightRanges = [
            '0-1 kg' => Product::where('weight', '>=', 0)->where('weight', '<=', 1)->count(),
            '1-5 kg' => Product::where('weight', '>', 1)->where('weight', '<=', 5)->count(),
            '5-10 kg' => Product::where('weight', '>', 5)->where('weight', '<=', 10)->count(),
            '10-25 kg' => Product::where('weight', '>', 10)->where('weight', '<=', 25)->count(),
            '25+ kg' => Product::where('weight', '>', 25)->count(),
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Produk',
                    'data' => array_values($weightRanges),
                    'backgroundColor' => [
                        '#E8F5E8', '#C8E6C9', '#A5D6A7', '#81C784', '#66BB6A'
                    ],
                    'borderColor' => [
                        '#4CAF50', '#4CAF50', '#4CAF50', '#4CAF50', '#4CAF50'
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => array_keys($weightRanges),
        ];
    }    protected function getType(): string
    {
        return 'doughnut';
    }
}
