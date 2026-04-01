<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

/**
 * Service Provider untuk custom Blade directives
 *
 * Menambahkan directive untuk security:
 * - @maskNik($nik) - Mask NIK untuk display
 * - @formatNik($nik) - Format NIK dengan spasi
 */
class BladeServiceProvider extends ServiceProvider
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
        // Directive untuk masking NIK
        Blade::directive('maskNik', function ($expression) {
            return "<?php echo \App\Helpers\NikHelper::mask($expression); ?>";
        });

        // Directive untuk format NIK
        Blade::directive('formatNik', function ($expression) {
            return "<?php echo \App\Helpers\NikHelper::format($expression); ?>";
        });

        // Directive untuk masking NIK tapi full untuk admin
        Blade::directive('maskNikAdmin', function ($expression) {
            return "<?php echo \App\Helpers\NikHelper::mask($expression, auth()->check() && auth()->user()?->hasRole('Admin')); ?>";
        });
    }
}
