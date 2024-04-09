<?php

namespace App\Filament\Pages\Experiments;

use Filament\Actions\Action;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Illuminate\Support\Str;

/**
 * @property \Filament\Forms\Form $form
 */
class GitHubPostCreator extends Page implements HasActions, HasForms
{
    use InteractsWithFormActions;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static string $view = 'filament.pages.experiments.github-post-creator';

    protected static ?string $title = 'GitHub Post Creator';

    protected static ?string $slug = 'experiments/github-post-creator';

    public ?string $repository;

    public ?string $branch;

    public ?string $postTitle;

    public ?string $content;

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
            TextInput::make('repository') // Todo add validation
                ->required()
                ->placeholder('https://github.com/hydephp/my-hyde-blog'),

            TextInput::make('branch')
                ->required()
                ->placeholder('main')
                ->default('main')
                ->datalist(['master', 'main']),

            TextInput::make('postTitle')
                ->placeholder('Hello World!')
                ->required(),

            Textarea::make('content')
                ->placeholder('Write something awesome!')
                ->required(),

            // Todo add additional front matter
        ];
    }

    public function getFormActions(): array
    {
        return [
            Action::make('Create blog post')
                ->submit(),
        ];
    }

    public function mount(): void
    {
        if (session()->has('github-post-creator-data')) {
            $state = session()->get('github-post-creator-data');
        }

        $this->form->fill($state ?? null);
    }

    public function create(): void
    {
        $repository = $this->getRepositoryUrl();
        $markdown = sprintf("%s\n\n%s", $this->assembleFrontMatter(), $this->content);
        $url = sprintf('%s/new/%s/_posts?%s', $repository, $this->branch, http_build_query([
            'filename' => Str::slug($this->postTitle).'.md',
            'value' => $markdown,
        ]));

        // Todo open modal with button to open in new tab, or to download markdown file. We could also display the markdown there.

        // Store the repo and branch in the user session state, so they can come back later and make more posts
        session()->put('github-post-creator-data', [
            'repository' => $repository,
            'branch' => $this->branch,
        ]);

        $this->redirect($url);
    }

    /** Get the normalized repository URL */
    protected function getRepositoryUrl(): string
    {
        $repo = $this->repository;
        $repo = str_replace('http://', 'https://', $repo);
        $repo = str_replace('www.github.com', 'github.com', $repo);

        if (str_starts_with($repo, 'github.com')) {
            $repo = 'https://'.$repo;
        }

        if (! str_starts_with($repo, 'https://github.com')) {
            $repo = 'https://github.com/'.$repo;
        }

        return trim($repo, '/');
    }

    protected function feedbackUrl(): string
    {
        return 'https://github.com/hydephp/central/issues/new?'.http_build_query([
            'title' => 'Feedback on experimental GitHub Post Creator',
            'labels' => 'feedback',
        ]);
    }

    protected function assembleFrontMatter(): string
    {
        return implode("\n", [
            '---',
            sprintf("title: '%s'", $this->postTitle),
            sprintf("date: '%s'", now()->format('Y-m-d H:i:s')),
            '---',
        ]);
    }
}
