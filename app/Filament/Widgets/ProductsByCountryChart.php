<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProductsByCountryChart extends ChartWidget
{
    protected static ?string $heading = 'Products by Country';
    
    protected static ?int $sort = 6;

    // Half width
    protected int | string | array $columnSpan = 1;

    protected static bool $isLazy = true;
    protected static ?string $pollingInterval = '120s';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return Cache::remember('admin_products_by_country', 300, function () {
            $countryData = Product::select('country_of_origin', DB::raw('count(*) as total'))
                ->where('status', 'approved')
                ->groupBy('country_of_origin')
                ->orderByDesc('total')
                ->take(10)
                ->get();

            $colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16', '#F97316', '#6366F1'];

            return [
                'datasets' => [
                    [
                        'label' => 'Products',
                        'data' => $countryData->pluck('total')->toArray(),
                        'backgroundColor' => array_slice($colors, 0, $countryData->count()),
                        'borderWidth' => 0,
                    ],
                ],
                'labels' => $countryData->pluck('country_of_origin')->toArray(),
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
            'cutout' => '55%',
        ];
    }
}
