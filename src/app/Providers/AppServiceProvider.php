<?php

namespace App\Providers;

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Expences;
use App\Models\House;
use App\Policies\CategoryPolicy;
use App\Policies\ExpencesPolicy;
use App\Policies\HousePolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(House::class, HousePolicy::class);
        Gate::policy(Expences::class, ExpencesPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
    }
}
