<?php

namespace App\Filament\Pages\Internal;

use Filament\Actions\Action;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Torchlight\Block;
use Torchlight\Client;
use Torchlight\Manager;
use Torchlight\Torchlight;

/** @copyright All rights reserved */
class TorchlightSnippetGenerator extends Page implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.internal.torchlight-snippet-generator';
    protected static ?string $slug = 'internal/torchlight-snippet-generator';

    public string $code = '';
    public string $language = 'php';
    public ?string $label = null;
    public int $width = 80;
    public int $padding = 1;
    public int $scale = 4;
    public string $lineNumbers = 'false';
    public string $useHeader = 'true';

    public ?string $html = null;

    public function mount(): void
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        //DEBUG
        // $this->code = '<p>Hello World!</p>';
        // $this->language = 'html';
        // $this->label = 'hello-world.html';
        // $this->lineNumbers = 'true';
        $this->generate();
    }

    public function generate(): void
    {
        $this->authorize('access-admin');

        Config::set(['torchlight.options.lineNumbers' => $this->lineNumbers]);

        $block = new Block();
        $block->code($this->code);
        $block->language($this->language);

        $torchlight = new Manager();
        $blocks = $torchlight->highlight($block);
        $highlighted = $blocks[0];
        $this->html = $highlighted->wrapped;
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(12)->schema([
                Section::make('Torchlight settings')->columnSpan(5)->schema([
                    Grid::make(12)->schema([
                        TextInput::make('language')
                            ->columnSpan(6)
                            ->required()
                            ->default('php')
                            ->datalist(['php', 'blade', 'md', 'html']),

                        Select::make('lineNumbers')
                            ->columnSpan(6)
                            ->options(['true' => 'Include line numbers', 'false' => 'No line numbers'])
                            ->default('false')
                    ])
                ]),

                Section::make('Code window settings')->columnSpan(7)->schema([
                    Grid::make(12)->schema([
                        TextInput::make('label')
                            ->placeholder('Optional label')
                            ->columnSpan(4),

                       Select::make('useHeader')
                           ->columnSpan(3)
                           ->options(['true' => 'Yes', 'false' => 'No'])
                           ->default('true'),

                        TextInput::make('width')
                            ->hint('(ch)')
                            ->columnSpan(2),

                        Select::make('padding')
                            ->columnSpan(2)
                            ->hint('(rem)')
                            ->options(['0', '1', '2', '3'])
                            ->default('true')
                    ])
                ]),
            ]),

            Textarea::make('code')
                ->rows(10)
                ->required()
        ];
    }

    public function getFormActions(): array
    {
        return [
            Action::make('generate')
                ->submit()
        ];
    }

    public function getFilename(): string
    {
        return Str::before($this->label, '.').'.png';
    }
}
