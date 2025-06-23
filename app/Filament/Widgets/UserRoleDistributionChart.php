<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;

class UserRoleDistributionChart extends ChartWidget
{    protected static ?string $heading = 'User Distribution : Importer vs Exporter';
    
    protected static ?int $sort = 14;

    protected int | string | array $columnSpan = 12;

    protected function getData(): array
    {
        // Get user count by role (only importir and eksportir)
        $importirCount = User::where('role', 'impor')->count();
        $eksportirCount = User::where('role', 'ekspor')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengguna',
                    'data' => [$importirCount, $eksportirCount],
                    'backgroundColor' => [
                        '#3B82F6', // Blue for importir
                        '#EF4444', // Red for eksportir
                    ],
                    'borderColor' => [
                        '#1D4ED8',
                        '#DC2626',
                    ],
                    'borderWidth' => 3,
                ],
            ],
            'labels' => ['Importir', 'Eksportir'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
