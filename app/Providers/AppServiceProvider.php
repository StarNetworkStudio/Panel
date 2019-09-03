<?php

namespace App\Providers;

use Blade;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Services\Option::class);
        $this->app->alias(\App\Services\Option::class, 'options');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('admin', function (User $user) {
            return $user->isAdmin();
        });
    }
}
