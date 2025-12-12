<?php

namespace App\Providers;

use App\Models\SeoPage;
use App\Models\SeoSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $setting = SeoSetting::current();
            $page = SeoPage::forCurrentUrl();

            if ($setting !== null) {
                // Глобальная настройка принудительно управляет robots для всего сайта
                $robots = $setting->global_indexing ? 'index, follow' : 'noindex, nofollow';
            } else {
                // Без глобальной настройки — используем значение страницы или дефолт
                $robots = ($page && $page->robots) ? $page->robots : 'noindex, follow';
            }

            $meta = [
                'title' => $page->title ?? config('app.name'),
                'description' => $page->description ?? null,
                'robots' => $robots,
                'canonical' => $page->canonical ?? null,
                'og' => [
                    'title' => $page->og_title ?? ($page->title ?? null),
                    'description' => $page->og_description ?? ($page->description ?? null),
                    'image' => $page->og_image ?? null,
                ],
                'h1' => $page->h1 ?? null,
                'structured_data' => $page->structured_data ?? null,
            ];

            $view->with('seo_meta', $meta);
        });
    }
}
