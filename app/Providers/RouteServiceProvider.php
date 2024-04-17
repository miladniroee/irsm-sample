<?php

namespace App\Providers;

use App\Enums\RoleType;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api/user.php'));

            Route::middleware(['api', 'auth:sanctum', 'role:' . RoleType::Admin->value])
                ->prefix('admin')
                ->group(base_path('routes/api/admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Route::bind('any_product',function ($value){
            return \App\Models\Product::withoutGlobalScopes()->findOrFail($value);
        });

        Route::bind('any_variation',function ($value){
            return \App\Models\ProductVariation::withoutGlobalScopes()->findOrFail($value);
        });
    }
}
