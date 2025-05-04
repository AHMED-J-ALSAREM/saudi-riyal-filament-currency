# Saudi Riyal Symbol Plugin for Laravel

حزمة لارافيل بسيطة وفعالة لاستبدال رموز الريال السعودي (SAR, ر.س, ر.س.) تلقائياً في جميع أنحاء التطبيق.

## المميزات

- استبدال تلقائي لرموز الريال السعودي في جميع أنحاء التطبيق
- دعم جميع أشكال الرمز (SAR, ر.س, ر.س.)
- لا حاجة لاستدعاء أي دوال إضافية
- يعمل على مستوى النظام كامل
- سهل التثبيت والاستخدام
- دعم كامل لـ Laravel Filament

## التثبيت

```bash
composer require ahmed-j-alsarem/saudi-riyal-filament-currency
```

## الإعداد

### الإعداد الأساسي

1. أضف مزود الخدمة في ملف `config/app.php`:
```php
'providers' => [
    // ...
    AhmedJAlsarem\SaudiRiyal\FilamentCurrency\SaudiRiyalSymbolServiceProvider::class,
],
```

### دعم Laravel Filament

إذا كنت تستخدم Laravel Filament، يمكنك إضافة دعم الرمز بطريقتين:

#### الطريقة الأولى: من خلال AdminPanelProvider
```php
// app/Providers/AdminPanelProvider.php
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->assets([
                Css::make('saudi-riyal-symbol', 'https://cdn.jsdelivr.net/npm/@emran-alhaddad/saudi-riyal-font/index.css'),
            ]);
    }
}
```

#### الطريقة الثانية: من خلال AppServiceProvider
```php
// app/Providers/AppServiceProvider.php
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        FilamentAsset::register([
            Css::make('saudi-riyal-symbol', 'https://cdn.jsdelivr.net/npm/@emran-alhaddad/saudi-riyal-font/index.css'),
        ]);
    }
}
```

## الاستخدام

بعد التثبيت والإعداد، سيتم تلقائياً:
- استبدال "SAR" بـ `<span class="icon-saudi_riyal"></span>`
- استبدال "ر.س" بـ `<span class="icon-saudi_riyal"></span>`
- استبدال "ر.س." بـ `<span class="icon-saudi_riyal"></span>`

### أمثلة

```php
// قبل: "100 SAR"
// بعد: "100 <span class="icon-saudi_riyal"></span>"

// قبل: "100 ر.س"
// بعد: "100 <span class="icon-saudi_riyal"></span>"

// قبل: "100 ر.س."
// بعد: "100 <span class="icon-saudi_riyal"></span>"
```

## التغطية

يعمل الباكدج على:
- جميع العروض (Views)
- جميع النصوص في التطبيق
- جميع الاستجابات (Responses)
- جميع أشكال الرمز مع أو بدون مسافات
- لوحة تحكم Filament بالكامل

## المساهمة

نرحب بمساهماتكم! يرجى اتباع الخطوات التالية:
1. Fork المشروع
2. إنشاء فرع جديد (`git checkout -b feature/amazing-feature`)
3. Commit التغييرات (`git commit -m 'Add some amazing feature'`)
4. Push إلى الفرع (`git push origin feature/amazing-feature`)
5. فتح Pull Request

## الترخيص

هذا المشروع مرخص تحت [MIT License](LICENSE.md).

## الدعم

إذا واجهتك أي مشكلة أو لديك أي استفسار، يرجى فتح issue في GitHub. 