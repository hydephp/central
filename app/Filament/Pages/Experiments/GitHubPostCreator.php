<?php

namespace App\Filament\Pages\Experiments;

use Filament\Navigation\NavigationItem;
use Filament\Pages\Page;

class GitHubPostCreator extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static string $view = 'filament.pages.experiments.github-post-creator';

    protected static ?string $title = 'GitHub Post Creator';
    protected static ?string $slug = 'experiments/github-post-creator';

    /** @experimental May be moved to custom base class */
    public static function navigationItem()
    {
        return NavigationItem::make('GitHub Post Creator')
            ->icon(static::$navigationIcon)
            ->url(fn (): string => static::getUrl())
            ->isActiveWhen(fn (): bool => request()->routeIs(static::getRouteName()));
    }
}
