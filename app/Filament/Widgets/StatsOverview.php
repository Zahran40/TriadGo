<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\User;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    // Cache stats for 5 minutes to reduce DB queries
    protected static ?string $pollingInterval = '60s';

    protected function getColumns(): int
    {
        return 3;
    }

    protected function getStats(): array
    {
        // Cache all stats for 5 minutes
        $stats = Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'totalProducts' => Product::where('status', 'approved')->count(),
                'totalImportir' => User::where('role', 'impor')->count(),
                'totalEksportir' => User::where('role', 'ekspor')->count(),
                'totalOrders' => CheckoutOrder::whereMonth('created_at', now()->month)
                    ->where('status', '!=', 'failed')
                    ->count(),
                'totalRevenue' => CheckoutOrder::whereMonth('created_at', now()->month)
                    ->where('status', '!=', 'failed')
                    ->sum('total_amount'),
                'pendingProducts' => Product::where('status', 'pending')->count(),
            ];
        });

        return [
            Stat::make('Total Active Products', $stats['totalProducts'])
                ->description('Approved Products')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5])
                ->chartColor('success'),
                
            Stat::make('Total Importer', $stats['totalImportir'])
                ->description('Buyer')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info')
                ->chart([3, 5, 4, 3, 6, 5, 7])
                ->chartColor('info'),
                
            Stat::make('Total Eksporter', $stats['totalEksportir'])
                ->description('Seller')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('warning')
                ->chart([2, 4, 3, 5, 4, 6, 5])
                ->chartColor('warning'),
                
            Stat::make('Order This Month', $stats['totalOrders'])
                ->description('Success Transactions')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary')
                ->chart([1, 3, 2, 4, 3, 5, 4])
                ->chartColor('primary'),
                
            Stat::make('Revenue This Month', 'Rp ' . number_format($stats['totalRevenue'], 0, ',', '.'))
                ->description('Total Income')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart([2, 4, 6, 5, 7, 3, 8])
                ->chartColor('success'),
                
            Stat::make('Pending Products', $stats['pendingProducts'])
                ->description('Waiting For Approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color($stats['pendingProducts'] > 0 ? 'danger' : 'gray')
                ->chart([1, 2, 1, 3, 2, 1, 2])
                ->chartColor($stats['pendingProducts'] > 0 ? 'danger' : 'gray'),
        ];
    }
}
