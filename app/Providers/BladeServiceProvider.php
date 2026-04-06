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

        // Share isAdmin variable ke semua views (cached)
        view()->composer('*', function ($view) {
            $isAdmin = false;
            if (auth()->check() && auth()->user()) {
                $isAdmin = auth()->user()->hasRole('Admin');
            }
            $view->with('isAdmin', $isAdmin);
        });

        // Directive untuk masking NIK tapi full untuk admin (optimized)
        Blade::directive('maskNikAdmin', function ($expression) {
            return "<?php echo \App\Helpers\NikHelper::mask($expression, $isAdmin ?? false); ?>";
        });
    }
}
