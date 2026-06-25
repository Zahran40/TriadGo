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
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\HtmlString;

// Widgets - registered manually to control order and avoid duplicates
use App\Filament\Widgets\CustomAccountWidget;
use App\Filament\Widgets\TriadGoInfoWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\ProductsByCategoryChart;
use App\Filament\Widgets\ProductStockChart;
use App\Filament\Widgets\UserRoleDistributionChart;
use App\Filament\Widgets\DailySalesChart;
use App\Filament\Widgets\ProductsByCountryChart;

class Admin1PanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin1')
            ->path('admin1')
            ->login()
            ->authGuard('web')
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
            // Don't use discoverWidgets - register manually to avoid duplicates and control order
            ->widgets([
                CustomAccountWidget::class,
                TriadGoInfoWidget::class,
                StatsOverview::class,
                DailySalesChart::class,
                ProductsByCategoryChart::class,
                UserRoleDistributionChart::class,
                ProductStockChart::class,
                ProductsByCountryChart::class,
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
                'admin.access',
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}