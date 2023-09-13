<?php

namespace App\Filament\Pages\Experiments;

use Filament\Pages\Page;

class GitHubPostCreator extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static string $view = 'filament.pages.experiments.github-post-creator';

    protected static ?string $title = 'GitHub Post Creator';
    protected static ?string $slug = 'experiments/github-post-creator';
}
