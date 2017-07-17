<?php

namespace App\Providers;

use App\Http\Controllers\QuoteController;
use App\QuoteCalculator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->instance(QuoteController::class, new QuoteController([
            'quote_calculator' => new QuoteCalculator()
        ]));
    }
}
