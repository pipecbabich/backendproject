<?php

namespace App\Providers;

use App\Http\Resources\CategoryResource;
use App\Services\Category\CategoryService;
use App\Services\Product\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('categories', CategoryService::class);
        $this->app->bind('products', ProductService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CategoryResource::withoutWrapping();
    }
}
