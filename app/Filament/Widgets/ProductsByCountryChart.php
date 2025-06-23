<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductsByCountryChart extends ChartWidget
{    protected static ?string $heading = 'Products by Country of Origin';
    
    protected static ?int $sort = 13;

    protected int | string | array $columnSpan = 12;

    protected function getData(): array
    {
        // Get products grouped by country
        $countryData = Product::select('country_of_origin', DB::raw('count(*) as total'))
            ->where('status', 'approved')
            ->groupBy('country_of_origin')
            ->orderByDesc('total')
            ->take(15)
            ->get();

        $labels = $countryData->pluck('country_of_origin')->toArray();
        $data = $countryData->pluck('total')->toArray();

        // Generate colors based on number of countries
        $colors = [];
        $baseColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
        for ($i = 0; $i < count($labels); $i++) {
            $colors[] = $baseColors[$i % count($baseColors)];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Produk',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderWidth' => 2,
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
