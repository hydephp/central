<?php

namespace App\Filament\Pages\Experiments;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Actions\Action;
use Filament\Pages\Page;

class GitHubPostCreator extends Page implements HasForms
{
    use InteractsWithForms;
    use InteractsWithFormActions;

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

    protected function getFormSchema(): array
    {
        return [
            //
        ];
    }

    public function getFormActions(): array
    {
        return [
            Action::make('Create blog post')
                ->submit()
        ];
    }

    public function create(): void
    {
        //
    }
}
