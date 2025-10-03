<?php

namespace App\Providers;

use App\Models\Store;
use App\Models\User;
use App\Policies\StorePolicy;
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
        // Gate::define('update-store', function (User $user, Store $store) {
        //     return $user->id === $store->user_id;
        // }); //ini kalau pakai gate

        Gate::policy(Store::class, StorePolicy::class);
    }
}