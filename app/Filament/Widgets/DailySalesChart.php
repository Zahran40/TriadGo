<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\CheckoutOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DailySalesChart extends ChartWidget
{
    protected static ?string $heading = 'Daily Importer Purchases (Last 30 Days)';
    
    protected static ?int $sort = 15;

    protected int | string | array $columnSpan = 12;

    protected function getData(): array
    {
        // Get daily sales for the last 30 days
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(29);

        $dailySales = CheckoutOrder::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->join('users', 'checkout_orders.user_id', '=', 'users.user_id')
            ->where('users.role', 'impor')
            ->where('checkout_orders.status', '!=', 'failed')
            ->whereBetween('checkout_orders.created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Fill in missing dates with zero values
        $dates = [];
        $orderCounts = [];
        $amounts = [];
        
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $dates[] = $date->format('M d');
            
            if (isset($dailySales[$dateString])) {
                $orderCounts[] = $dailySales[$dateString]->total_orders;
                $amounts[] = round($dailySales[$dateString]->total_amount, 2);
            } else {
                $orderCounts[] = 0;
                $amounts[] = 0;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Number of Orders',
                    'data' => $orderCounts,
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Total Sales (IDR)',
                    'data' => $amounts,
                    'borderColor' => '#EF4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'interaction' => [
                'intersect' => false,
            ],
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Number of Orders',
                    ],
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Total Sales (IDR)',
                    ],
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }
}
