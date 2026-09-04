<?php

namespace App\Providers;

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
        Gate::define('view-dashboard', function ($user) {
            return $user->hasPermission('view_dashboard');
        });

        Gate::define('manage-users', function ($user) {
            return $user->hasPermission('manage_users');
        });

        Gate::define('manage-roles', function ($user) {
            return $user->hasPermission('manage_roles');
        });

        Gate::define('manage-permissions', function ($user) {
            return $user->hasPermission('manage_permissions');
        });

        Gate::define('manage-content', function ($user) {
            return $user->hasPermission('manage_content');
        });

        Gate::define('review-content', function ($user) {
            return $user->hasPermission('review_content');
        });
    }
}