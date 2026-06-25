<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserRoleDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'User Distribution';
    
    protected static ?int $sort = 4;

    // Half width — sits side by side with ProductsByCategory
    protected int | string | array $columnSpan = 1;

    protected static bool $isLazy = true;
    protected static ?string $pollingInterval = '120s';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return Cache::remember('admin_user_role_chart', 300, function () {
            $importirCount = User::where('role', 'impor')->count();
            $eksportirCount = User::where('role', 'ekspor')->count();

            return [
                'datasets' => [
                    [
                        'label' => 'Users',
                        'data' => [$importirCount, $eksportirCount],
                        'backgroundColor' => [
                            '#3B82F6',
                            '#F59E0B',
                        ],
                        'borderWidth' => 0,
                    ],
                ],
                'labels' => ['Importir', 'Eksportir'],
            ];
        });
    }

    protected function getType(): string
    {
        return 'pie';
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
        ];
    }
}
