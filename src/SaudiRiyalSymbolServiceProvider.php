<?php

namespace AhmedJAlsarem\SaudiRiyal\FilamentCurrency;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use AhmedJAlsarem\SaudiRiyal\FilamentCurrency\Services\SaudiRiyalFormatter;

class SaudiRiyalSymbolServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // استبدال في جميع العروض
        View::composer('*', function ($view) {
            $data = $view->getData();
            foreach ($data as $key => $value) {
                if (is_string($value)) {
                    $data[$key] = SaudiRiyalFormatter::replaceSymbols($value);
                }
            }
            $view->with($data);
        });

        // استبدال في جميع الاستجابات
        Response::macro('replaceSymbols', function ($content) {
            if (is_string($content)) {
                return SaudiRiyalFormatter::replaceSymbols($content);
            }
            return $content;
        });

        // استبدال في جميع النصوص في التطبيق
        $this->app->bind('saudi-riyal-formatter', function () {
            return new SaudiRiyalFormatter();
        });
    }

    public function register(): void
    {
        // لا حاجة لتسجيل أي شيء إضافي
    }
} 