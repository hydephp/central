<?php

namespace App\Filament\Pages\Experiments;

use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Str;

/**
 * @property \Filament\Forms\Form $form
 */
class GitHubPostCreator extends Page implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithFormActions;

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
                ->required()
        ];
    }

    public function getFormActions(): array
    {
        return [
            Action::make('Create blog post')
                ->submit()
        ];
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function create(): void
    {
        $repository = $this->getRepositoryUrl();
        $markdown = $this->content; // Todo assemble front matter
        $url = $repository . '/new/'.$this->branch.'/_posts?'.http_build_query([
            'filename' => Str::slug($this->postTitle).'.md',
            'value' => $markdown
        ]);

        // Todo open modal with button to open in new tab, or to download markdown file. We could also display the markdown there.

        $this->redirect($url);
    }

    protected function getRepositoryUrl(): string
    {
        $repo = $this->repository;
        // Todo add https if not present
        $repo = trim($repo, '/');
        return $repo;
    }
}
