<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class BrandMedia extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static string $view = 'filament.pages.brand-media';

    protected function getItems(): array
    {
        return $this->fetchFileTree();
    }

    protected function fetchFileTree(): array
    {
        $fileTree = [];
        $response = $this->connect('https://api.github.com/repos/hydephp/hydephp/contents/assets');

        foreach ($response->object() as $object) {
            if ($object->type === 'file') {
                $fileTree[] = $object;
            } else {
                $childItems = $this->fetch($object->path);
                foreach ($childItems as $child) {
                    $fileTree[] = $child;
                }
            }
        }

        return $fileTree;
    }

    protected function fetch(string $path): array
    {
        $fileTree = [];
        $response = $this->connect('https://api.github.com/repos/hydephp/hydephp/contents/'.$path);
        foreach ($response->object() as $object) {
            if ($object->type === 'file') {
                $fileTree[] = $object;
            } else {
                $childItems = $this->fetch($object->path);
                foreach ($childItems as $child) {
                    $fileTree[] = $child;
                }
            }
        }
        return $fileTree;
    }

    protected function connect(string $url): Response
    {
        return Http::withToken(config('services.github.token'))->throw()->get($url);
    }
}
