<?php

namespace App\Providers;

use App\Models\ProductionProcess;
use App\Models\StockTransaction;
use App\Observers\ProductionProcessObserver;
use App\Observers\StockTransactionObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        StockTransaction::observe(StockTransactionObserver::class);
        ProductionProcess::observe(ProductionProcessObserver::class);

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
