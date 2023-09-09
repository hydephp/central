<?php

namespace App\Views;

use Closure;
use Illuminate\View\View;

/**
 * Helper class for rendering components into Filament render hooks.
 */
abstract class FilamentRenderView
{
    protected static string $view;

    public static function make(): Closure
    {
        return fn (): View => view(static::$view, [static::$view => new static()]);
    }

    final public static function anonymous(string $view): Closure
    {
        return fn (): View => view($view);
    }
}
