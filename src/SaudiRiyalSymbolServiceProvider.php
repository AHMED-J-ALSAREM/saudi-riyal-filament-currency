<?php

namespace AhmedJAlsarem\SaudiRiyal\FilamentCurrency;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;

class SaudiRiyalSymbolServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // نشر ملف CSS تلقائياً
        FilamentAsset::register([
            Css::make('saudi-riyal-symbol', __DIR__ . '/../resources/dist/filament-currency.css'),
        ], 'ahmed-j-alsarem/saudi-riyal-filament-currency');

        // إضافة ديركتيف Blade لاستبدال الرمز
        Blade::directive('saudiRiyalSymbol', function ($expression) {
            return "<?php echo \\AhmedJAlsarem\\SaudiRiyal\\FilamentCurrency\\Helpers::replaceSymbol($expression); ?>";
        });
    }
} 