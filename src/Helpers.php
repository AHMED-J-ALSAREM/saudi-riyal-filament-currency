<?php

namespace AhmedJAlsarem\SaudiRiyal\FilamentCurrency;

class Helpers
{
    public static function replaceSymbol($value): string
    {
        $icon = '<span class="icon-saudi_riyal"></span>';
        
        // قائمة بكل أشكال رمز الريال السعودي
        $symbols = [
            'SAR',           // الرمز الدولي
            'ر.س',          // الرمز العربي
            'ريال سعودي',   // الاسم الكامل
            'ريال',         // الاسم المختصر
            'SR',           // اختصار آخر
            '﷼',           // رمز الريال Unicode
        ];

        return str_replace($symbols, $icon, $value);
    }
} 