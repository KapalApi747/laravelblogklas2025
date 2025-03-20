<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class GlobalDataServiceProvider extends ServiceProvider
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
//    public function boot(): void
//    {
//        // Globale cache-gegevens voor alle views beschikbaar maken
//        View::composer('*', function ($view) {
//            // Cache gebruikersstatistieken
//            $totalUsers = Cache::remember('totalUsers', 600, fn() => User::count());
//            $activeUsers = Cache::remember('activeUsers', 600, fn() => User::where('is_active', 1)->count());
//            $inactiveUsers = $totalUsers - $activeUsers;
//
//            // Cache post-statistieken
//            $totalPosts = Cache::remember('totalPosts', 600, fn() => Post::count());
//            $publishedPosts = Cache::remember('publishedPosts', 600, fn() => Post::where('is_published', 1)->count());
//            $unpublishedPosts = $totalPosts - $publishedPosts;
//
//            // Stuur deze data naar alle views
//            $view->with(compact(
//                'totalUsers', 'activeUsers', 'inactiveUsers',
//                'totalPosts', 'publishedPosts', 'unpublishedPosts'
//            ));
//        });
//    }
    public function boot(): void
    {
        // View Composer alleen voor admin-gerelateerde views
        View::composer(['backend.*'], function ($view) {
            $cacheKey = 'global_data';
            // Check of de cache bestaat, anders haal nieuwe data op
            $cacheData = Cache::remember($cacheKey, now()->addMinutes(10), function () {
                return [
                    'totalUsers'    => User::count(),
                    'activeUsers'   => User::where('is_active', 1)->count(),
                    'inactiveUsers' => User::where('is_active', 0)->count(),
                    'totalPosts'    => Post::count(),
                    'publishedPosts' => Post::where('is_published', 1)->count(),
                    'unpublishedPosts' => Post::where('is_published', 0)->count(),
                ];
            });
            $view->with($cacheData);
        });
        // Cache vernieuwen bij wijzigingen in User of Post model of andere toekomstige modellen.
        foreach ([Post::class, User::class] as $model) {
            $model::saved(fn() => Cache::forget('global_data'));
            $model::deleted(fn() => Cache::forget('global_data'));
        }
    }
}
