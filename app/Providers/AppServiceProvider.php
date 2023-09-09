<?php

namespace App\Providers;

use App\Views\FilamentRenderView;
use App\Views\Footer;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        FilamentView::registerRenderHook('panels::body.end', Footer::make());
        FilamentView::registerRenderHook('panels::auth.login.form.after', FilamentRenderView::anonymous('components.login-as-guest-button'));

        Str::macro('bytesToHuman', /** Format the given number of bytes into a human-readable format. */
            function (int $bytes, $precision = 2): string {
                for ($i = 0; $bytes > 1024; $i++) {
                    $bytes /= 1024;
                }

                return round($bytes, $precision).' '.['B', 'KB', 'MB', 'GB', 'TB'][$i];
            }
        );
    }
}
