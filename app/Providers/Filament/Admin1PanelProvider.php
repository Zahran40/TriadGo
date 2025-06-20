<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\ProductsByCategoryChart;
use App\Filament\Widgets\ProductStockChart;
use App\Filament\Widgets\ProductWeightChart;
use App\Filament\Widgets\ProductsByCountryChart;
use App\Filament\Widgets\UserRoleDistributionChart;
use App\Filament\Widgets\DailySalesChart;
use Illuminate\Support\HtmlString;
use App\Filament\Widgets\TriadGoInfoWidget;
use App\Filament\Widgets\CustomAccountWidget;

class Admin1PanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin1')
            ->path('admin1')
            ->login() // Enable login Filament
            ->authGuard('web') // Use web guard
            ->brandName('TriadGO Admin Panel')
            ->brandLogo(new HtmlString('<div class="flex items-center space-x-2"><img src="' . asset('tglogo.png') . '" alt="TriadGO" class="h-8 w-8"><span class="text-lg font-semibold">TriadGO</span></div>'))
            ->favicon(asset('favicon.ico'))
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                StatsOverview::class,
                CustomAccountWidget::class,
                TriadGoInfoWidget::class,
                ProductsByCategoryChart::class,
                ProductStockChart::class,
                ProductWeightChart::class,
                ProductsByCountryChart::class,
                UserRoleDistributionChart::class,
                DailySalesChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                'admin.access', // Gunakan alias middleware
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}