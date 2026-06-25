<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\CheckoutOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DailySalesChart extends ChartWidget
{
    protected static ?string $heading = 'Daily Purchases (Last 30 Days)';
    
    protected static ?int $sort = 2;

    // Full width for the line chart
    protected int | string | array $columnSpan = 'full';

    // Lazy load this chart
    protected static bool $isLazy = true;

    // Reduce polling - no need to refresh sales chart every 5s
    protected static ?string $pollingInterval = '120s';

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        return Cache::remember('admin_daily_sales_chart', 300, function () {
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
                        'fill' => true,
                        'tension' => 0.4,
                        'yAxisID' => 'y',
                    ],
                    [
                        'label' => 'Total Sales (IDR)',
                        'data' => $amounts,
                        'borderColor' => '#10B981',
                        'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                        'fill' => true,
                        'tension' => 0.4,
                        'yAxisID' => 'y1',
                    ],
                ],
                'labels' => $dates,
            ];
        });
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
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Orders',
                    ],
                    'beginAtZero' => true,
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Sales (IDR)',
                    ],
                    'beginAtZero' => true,
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }
}
