# Saudi Riyal Filament Currency

حزمة لارافيل لتنسيق وعرض الريال السعودي في تطبيقات Filament مع دعم كامل للغة العربية.

## المميزات

- استبدال تلقائي لرموز الريال السعودي (SAR، ر.س، ر.س.)
- دعم كامل للغة العربية
- تكامل مع Filament
- دعم Livewire
- تنسيق تلقائي للأرقام
- إمكانية التحكم اليدوي في الاستبدال

## التثبيت

```bash
composer require ahmed-j-alsarem/saudi-riyal-filament-currency
```

## الإعداد

1. أضف Service Provider في `config/app.php`:
```php
'providers' => [
    // ...
    AhmedJAlsarem\SaudiRiyal\FilamentCurrency\SaudiRiyalSymbolServiceProvider::class,
]
```

2. أضف ملف CSS في `app/Providers/AdminPanelProvider.php`:
```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->login()
        ->colors([
            'primary' => Color::Amber,
        ])
        ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
        ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
        ->pages([
            Pages\Dashboard::class,
        ])
        ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
        ->widgets([
            Widgets\AccountWidget::class,
            Widgets\FilamentInfoWidget::class,
        ])
        ->middleware([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DisableBladeIconComponents::class,
            DispatchServingFilamentEvent::class,
        ])
        ->authMiddleware([
            Authenticate::class,
        ])
        ->viteTheme('resources/css/filament/admin/theme.css')
        ->assets([
            'https://cdn.jsdelivr.net/npm/@emran-alhaddad/saudi-riyal-font/index.css',
        ]);
}
```

## الاستخدام

### 1. الاستخدام الأساسي (الاستبدال التلقائي)

بمجرد تثبيت الباكدج، سيتم استبدال جميع رموز الريال السعودي تلقائياً في التطبيق. لا تحتاج لأي إعدادات إضافية.

### 2. التحكم اليدوي في الاستبدال

إذا كنت تريد التحكم يدوياً في مكان معين:

```php
@php
    // تعطيل الاستبدال التلقائي
    \AhmedJAlsarem\SaudiRiyal\FilamentCurrency\Services\SaudiRiyalFormatter::disable();

    // كودك الخاص هنا
    $price = 1000;
    $formattedPrice = number_format($price, 2) . ' <span class="icon-saudi_riyal"></span>';

    // تفعيل الاستبدال التلقائي مرة أخرى
    \AhmedJAlsarem\SaudiRiyal\FilamentCurrency\Services\SaudiRiyalFormatter::enable();
@endphp
```

### 3. استخدام مع Number::currency

```php
@php
    $price = 1000;
    $formattedPrice = Number::currency($price, 'SAR', app()->getLocale());
@endphp
```

### 4. استخدام في Filament

#### في أعمدة الجداول:
```php
TextColumn::make('price')
    ->formatStateUsing(function ($state) {
        return number_format($state, 2) . ' <span class="icon-saudi_riyal"></span>';
    })
```

#### في حقول النماذج:
```php
TextInput::make('price')
    ->numeric()
    ->formatStateUsing(function ($state) {
        return number_format($state, 2) . ' <span class="icon-saudi_riyal"></span>';
    })
```

### 5. استخدام في Livewire

```php
public function render()
{
    return view('livewire.your-component', [
        'price' => number_format($this->price, 2) . ' <span class="icon-saudi_riyal"></span>'
    ]);
}
```

## أمثلة إضافية

### تنسيق السعر مع اللغة العربية
```php
@php
    $price = 1000;
    $formattedPrice = app()->getLocale() === 'ar' 
        ? number_format($price, 2, '.', ',') . ' <span class="icon-saudi_riyal"></span>'
        : Number::currency($price, 'SAR', app()->getLocale());
@endphp
```

### استخدام في Blade مباشرة
```php
<span class="price">
    {{ number_format($price, 2) }} <span class="icon-saudi_riyal"></span>
</span>
```

## ملاحظات مهمة

1. تأكد من إضافة ملف CSS في كل صفحة تستخدم فيها الرمز
2. يمكنك تعطيل الاستبدال التلقائي في أي وقت باستخدام `disable()`
3. الباكدج يدعم جميع أشكال كتابة الريال السعودي (SAR، ر.س، ر.س.)
4. يتم تنسيق الأرقام تلقائياً حسب إعدادات اللغة

## المساهمة

نرحب بمساهماتكم! يرجى فتح issue أو pull request للمساهمة في تحسين الباكدج.

## الترخيص

هذا الباكدج مرخص تحت [MIT license](LICENSE.md).

## الدعم

إذا واجهتك أي مشكلة أو لديك أي استفسار، يرجى فتح issue في GitHub. 