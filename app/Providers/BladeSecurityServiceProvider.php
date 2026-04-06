<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeSecurityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share role check variables ke semua views (hanya sekali query!)
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                $view->with('isAdmin', $user->hasRole('Admin'))
                      ->with('isKeagamaan', $user->hasRole('Keagamaan'))
                      ->with('userRoles', $user->roles->pluck('name')->toArray());
            } else {
                $view->with('isAdmin', false)
                      ->with('isKeagamaan', false)
                      ->with('userRoles', []);
            }
        });

        // Directive for masking sensitive data
        Blade::directive('mask', function ($expression) {
            return "<?php echo e(\\App\\Helpers\\SecurityHelper::maskSensitiveData({$expression})); ?>";
        });

        // Directive for masking NIK (default: show first 4 and last 4)
        Blade::directive('maskNik', function ($expression) {
            return "<?php echo e(\\App\\Helpers\\SecurityHelper::maskSensitiveData({$expression}, 4)); ?>";
        });

        // Directive for masking NIK with admin check (optimized)
        Blade::directive('maskNikAdmin', function ($expression) {
            return "<?php
                if ({$isAdmin} ?? false) {
                    echo e({$expression});
                } else {
                    echo e(\\App\\Helpers\\SecurityHelper::maskSensitiveData({$expression}, 4));
                }
            ?>";
        });

        // Directive for checking if current user is admin (optimized)
        Blade::if('admin', function () {
            return isset($isAdmin) ? $isAdmin : (auth()->check() && auth()->user()->hasRole('Admin'));
        });

        // Directive for checking if current user is keagamaan (optimized)
        Blade::if('keagamaan', function () {
            return isset($isKeagamaan) ? $isKeagamaan : (auth()->check() && auth()->user()->hasRole('Keagamaan'));
        });

        // Directive for checking role (optimized)
        Blade::if('role', function ($role) {
            if (isset($userRoles) && is_array($userRoles)) {
                return in_array($role, $userRoles);
            }
            return auth()->check() && auth()->user()->hasRole($role);
        });

        // Directive for safe JavaScript value
        Blade::directive('js', function ($expression) {
            return "<?php echo json_encode({$expression}); ?>";
        });
    }
}
