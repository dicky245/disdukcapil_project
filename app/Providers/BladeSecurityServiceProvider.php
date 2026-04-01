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
        // Directive for masking sensitive data
        Blade::directive('mask', function ($expression) {
            return "<?php echo e(\\App\\Helpers\\SecurityHelper::maskSensitiveData({$expression})); ?>";
        });

        // Directive for masking NIK (default: show first 4 and last 4)
        Blade::directive('maskNik', function ($expression) {
            return "<?php echo e(\\App\\Helpers\\SecurityHelper::maskSensitiveData({$expression}, 4)); ?>";
        });

        // Directive for masking NIK with admin check
        Blade::directive('maskNikAdmin', function ($expression) {
            return "<?php
                if (auth()->check() && auth()->user()->hasRole('Admin')) {
                    echo e({$expression});
                } else {
                    echo e(\\App\\Helpers\\SecurityHelper::maskSensitiveData({$expression}, 4));
                }
            ?>";
        });

        // Directive for checking if current user is admin
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->hasRole('Admin');
        });

        // Directive for checking if current user is keagamaan
        Blade::if('keagamaan', function () {
            return auth()->check() && auth()->user()->hasRole('Keagamaan');
        });

        // Directive for checking role
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        // Directive for safe JavaScript value
        Blade::directive('js', function ($expression) {
            return "<?php echo json_encode({$expression}); ?>";
        });
    }
}
