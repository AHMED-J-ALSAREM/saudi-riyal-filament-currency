<?php

namespace AhmedJAlsarem\SaudiRiyal\FilamentCurrency;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use AhmedJAlsarem\SaudiRiyal\FilamentCurrency\Services\SaudiRiyalFormatter;
use Filament\Support\Concerns\InteractsWithForms;
use Filament\Panel;

class SaudiRiyalSymbolServiceProvider extends ServiceProvider
{
    use InteractsWithForms;

    /**
     * هل الباكدج مفعل
     */
    protected static $enabled = true;

    /**
     * إنشاء نسخة جديدة من الباكدج
     */
    public static function make(): static
    {
        return new static();
    }

    /**
     * تفعيل الباكدج
     */
    public static function enable(): void
    {
        self::$enabled = true;
    }

    /**
     * تعطيل الباكدج
     */
    public static function disable(): void
    {
        self::$enabled = false;
    }

    /**
     * التحقق من حالة الباكدج
     */
    public static function isEnabled(): bool
    {
        return self::$enabled;
    }

    public function boot(): void
    {
        // التحقق من حالة الباكدج قبل تنفيذ أي عملية
        if (!self::$enabled) {
            return;
        }

        // استبدال في جميع العروض
        View::composer('*', function ($view) {
            if (!self::$enabled) {
                return;
            }

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
            if (!self::$enabled) {
                return $content;
            }

            if (is_string($content)) {
                return SaudiRiyalFormatter::replaceSymbols($content);
            }
            return $content;
        });

        // استبدال في جميع النصوص في التطبيق
        $this->app->bind('saudi-riyal-formatter', function () {
            return new SaudiRiyalFormatter();
        });

        // استبدال في Livewire responses
        $this->app->afterResolving('livewire', function ($livewire) {
            if (!self::$enabled) {
                return;
            }

            $livewire->setResponse(function ($response) {
                if (is_string($response)) {
                    return SaudiRiyalFormatter::replaceSymbols($response);
                }
                return $response;
            });
        });
    }

    public function register(): void
    {
        // لا حاجة لتسجيل أي شيء إضافي
    }
} 