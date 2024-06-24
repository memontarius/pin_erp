<?php

namespace App\Providers;

use App\Enums\UserRoles;
use App\Models\User;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ProductService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('update-product-article', function (User $user) {
            return $user->role() === UserRoles::Admin;
        });
    }
}
