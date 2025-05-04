# Saudi Riyal Symbol Plugin for Filament

حزمة بسيطة لـ Laravel Filament تقوم باستبدال رمز الريال السعودي (SAR, ر.س) تلقائياً بأيقونة الخط الجديد في جميع أنحاء لوحة التحكم.

## المميزات

- استبدال تلقائي لجميع أشكال رمز الريال السعودي:
  - SAR (الرمز الدولي)
  - ر.س (الرمز العربي)
  - ريال سعودي (الاسم الكامل)
  - ريال (الاسم المختصر)
  - SR (اختصار آخر)
  - ﷼ (رمز الريال Unicode)
- دعم كامل للغة العربية (RTL)
- تثبيت سهل وتشغيل فوري
- لا يؤثر على أي تنسيقات أو عملات أخرى

## التثبيت

```bash
composer require ahmed-j-alsarem/saudi-riyal-filament-currency
```

## الاستخدام

### في أعمدة الجداول

```php
use Filament\Tables\Columns\TextColumn;

TextColumn::make('price')
    ->money('SAR') // أو 'ر.س'
    ->formatStateUsing(fn($state) => app('blade.compiler')->compileString("@saudiRiyalSymbol('{$state}')"))
    ->html();
```

### في حقول النماذج

```php
use Filament\Forms\Components\TextInput;

TextInput::make('price')
    ->money('SAR') // أو 'ر.س'
    ->formatStateUsing(fn($state) => app('blade.compiler')->compileString("@saudiRiyalSymbol('{$state}')"))
    ->html();
```

### في أي مكان في Blade

```blade
@saudiRiyalSymbol($amount)
```

## مثال عملي

قبل البلجن:
```php
"100 SAR" -> "100 SAR"
"100 ر.س" -> "100 ر.س"
"100 ريال سعودي" -> "100 ريال سعودي"
```

بعد البلجن:
```php
"100 SAR" -> "100 <span class='icon-saudi_riyal'></span>"
"100 ر.س" -> "100 <span class='icon-saudi_riyal'></span>"
"100 ريال سعودي" -> "100 <span class='icon-saudi_riyal'></span>"
```

## التخصيص

إذا أردت إضافة أشكال أخرى لرمز الريال السعودي، يمكنك تعديل ملف `src/Helpers.php` وإضافة الرموز الجديدة في مصفوفة `$symbols`.

## الترخيص

الترخيص MIT. راجع ملف [LICENSE](LICENSE.md) للمزيد من المعلومات. 