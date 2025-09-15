<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\User;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        // Total products approved
        $totalProducts = Product::where('status', 'approved')->count();
        
        // Total importir users
        $totalImportir = User::where('role', 'impor')->count();
        
        // Total eksportir users
        $totalEksportir = User::where('role', 'ekspor')->count();
        
        // Total successful orders this month
        $totalOrders = CheckoutOrder::whereMonth('created_at', now()->month)
            ->where('status', '!=', 'failed')
            ->count();
        
        // Total revenue this month
        $totalRevenue = CheckoutOrder::whereMonth('created_at', now()->month)
            ->where('status', '!=', 'failed')
            ->sum('total_amount');
        
        // Pending products for approval
        $pendingProducts = Product::where('status', 'pending')->count();

        return [
            Stat::make('Total Active Products', $totalProducts)
                ->description('Approved Products')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
                
            Stat::make('Total Importer', $totalImportir)
                ->description('Buyer')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),
                
            Stat::make('Total Eksporter', $totalEksportir)
                ->description('Seller')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('warning'),
                
            Stat::make('Order This Month', $totalOrders)
                ->description('Success Transactions')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
                
            Stat::make('Revenue This Month', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Total Income')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
                
            Stat::make('Pending Products', $pendingProducts)
                ->description('Waiting For Approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingProducts > 0 ? 'danger' : 'gray'),
        ];
    }
}
