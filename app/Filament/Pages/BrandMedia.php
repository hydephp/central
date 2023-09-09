<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BrandMedia extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static string $view = 'filament.pages.brand-media';

    protected function getItems(): array
    {
        // Todo: It would be better to use the current HEAD SHA as the cache key instead of a TTL,
        //       that we would always get the latest data but with only one external request.
        //       (We may want to bust old caches though to save on disk space if we need)
        //       (A more efficient solution is of course to have a webhook to trigger
        //       a database key but that is way to much over-engineering for now)
        return Cache::remember('brand-media', 600, function () {
            $items = [];
            foreach ($this->fetchFileTree() as $node) {
                if ($this->isFilenameForImage($node->name)) {
                    $items[] = (object) [
                        'name' => $node->name,
                        'path' => $node->path,
                        'size' => $node->size,
                        'link' => $node->html_url,
                        'download' => $node->download_url,
                    ];
                }
            }

            return $items;
        });
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

    protected function isFilenameForImage(string $name): bool
    {
        return in_array(pathinfo($name, PATHINFO_EXTENSION), [
            'png', 'svg', 'jpg', 'jpeg',
        ]);
    }
}
