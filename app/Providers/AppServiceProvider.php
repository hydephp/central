<?php

namespace App\Providers;

use App\Views\FilamentRenderView;
use App\Views\Footer;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
    }
}
