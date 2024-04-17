<?php

namespace App\Providers;

use App\Models\ProductVariation;
use App\Policies\ProductVariationPolicy;
use Illuminate\Support\Facades\Gate;;
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
        Gate::define('update-product-variation',[ProductVariationPolicy::class,'update']);
        Gate::define('create-product-variation',[ProductVariationPolicy::class,'create']);
    }
}
