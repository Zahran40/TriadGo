<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CheckoutOrder;
use App\Observers\CheckoutOrderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register observers
        CheckoutOrder::observe(CheckoutOrderObserver::class);
    }
}
