<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NewsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $apiKey = config('services.newsapi.key');
        // Cache breaking news voor 5 minuten
        $brNews = Cache::remember('brNews', now()->addMinutes(5), function () use ($apiKey) {
            return $this->fetchBreakingNews($apiKey);
        });
        View::share('brNews', $brNews);
    }

    private function fetchBreakingNews($apiKey)
    {
        $response = Http::withoutVerifying()->get('https://newsapi.org/v2/top-headlines', [
            'country' => 'be',
            'category' => 'general',
            'apiKey' => $apiKey,
        ]);
        $articles = $response->json()['articles'] ?? [];

        // Converteer naar een eenvoudiger array
        return collect($articles)->map(function ($article) {
            return [
                'title' => $article['title'] ?? 'Geen titel',
                'url' => $article['url'] ?? '#',
                'publishedAt' => isset($article['publishedAt']) ? date('H:i', strtotime($article['publishedAt'])) : 'Onbekend',
            ];
        })->take(10); // Haal alleen de laatste 10 nieuwsberichten
    }
}
