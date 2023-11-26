<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpcomingFeatures extends Widget
{
    protected static string $view = 'filament.widgets.upcoming-features';
    protected int | string | array $columnSpan = 'full';

    public array $features;
    public bool $failedToLoad = false;

    public function mount(): void
    {
        try {
            $this->features = Cache::remember('upcoming-features', 60 * 30, function (): array {
                return $this->loadFeatures();
            });
        } catch (\Throwable $exception) {
            $this->failedToLoad = true;
            Log::error($exception);
        }
    }

    private function loadFeatures(): array
    {
        // Get pull requests since the last release from the GitHub API
        return $this->getPullRequestsSinceLastRelease();
    }

    private function getPullRequestsSinceLastRelease(): array
    {
        $accessToken = config('services.github.token');

        // Get the latest release
        $latestRelease = Http::withToken($accessToken)->throw()
            ->get("https://api.github.com/repos/hydephp/develop/releases/latest")->json();

        // Get pull requests
        $response = Http::withToken($accessToken)->throw()
            ->get("https://api.github.com/repos/hydephp/develop/pulls", [
                'state' => 'all',
                'sort' => 'created',
                'direction' => 'desc',
            ]);

        $pullRequests = $response->json();

        // Filter pull requests
        $pullRequests = array_filter($pullRequests, function ($pullRequest) use ($latestRelease) {
            return strtotime($pullRequest['created_at']) > strtotime($latestRelease['published_at']);
        });

        // Sort pull requests (open first, then closed, then merged sorted alphabetically)
        usort($pullRequests, function ($a, $b) {
            if ($a['state'] === 'open' && $b['state'] !== 'open') {
                return -1;
            }

            if ($a['state'] !== 'open' && $b['state'] === 'open') {
                return 1;
            }

            if ($a['merged_at'] !== null && $b['merged_at'] === null) {
                return -1;
            }

            if ($a['merged_at'] === null && $b['merged_at'] !== null) {
                return 1;
            }

            return strcmp($a['title'], $b['title']);
        });

        // Format data
        return array_map(function (array $pullRequest): object {
            return (object) [
                'title' => $pullRequest['title'],
                'url' => $pullRequest['html_url'],
                'id' => $pullRequest['number'],
                'created_at' => $pullRequest['created_at'],
                'is_open' => $pullRequest['state'] === 'open',
                'merged' => $pullRequest['merged_at'] !== null,
            ];
        }, $pullRequests);
    }
}
