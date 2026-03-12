<?php

namespace App\Providers;

use App\View\Composers\AdminExistsComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Register AdminExistsComposer untuk semua views
        View::composer('*', AdminExistsComposer::class);
    }
}
