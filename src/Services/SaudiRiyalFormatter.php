<?php

namespace AhmedJAlsarem\SaudiRiyal\FilamentCurrency\Services;

use Illuminate\Support\Number;

class SaudiRiyalFormatter
{
    private static $disabled = false;

    /**
     * تعطيل الاستبدال التلقائي
     */
    public static function disable(): void
    {
        self::$disabled = true;
    }

    /**
     * تفعيل الاستبدال التلقائي
     */
    public static function enable(): void
    {
        self::$disabled = false;
    }

    /**
     * تنسيق السعر مع الرمز
     */
    public static function formatPrice($price, $locale = null): string
    {
        if ($locale === null) {
            $locale = app()->getLocale();
        }

        $formattedPrice = $locale === 'ar' 
            ? number_format($price, 2, '.', ',')
            : number_format($price, 2);

        return $formattedPrice . ' <span class="icon-saudi_riyal"></span>';
    }

    /**
     * استبدال رموز الريال السعودي بالرمز الجديد
     */
    public static function replaceSymbols($text): string
    {
        if (!is_string($text) || self::$disabled) {
            return $text;
        }

        // استبدال جميع أشكال الرمز مع إضافة مسافة
        $replacements = [
            'SAR' => ' <span class="icon-saudi_riyal"></span>',
            'ر.س' => ' <span class="icon-saudi_riyal"></span>',
            'ر.س.' => ' <span class="icon-saudi_riyal"></span>',
            'SAR ' => ' <span class="icon-saudi_riyal"></span> ',
            'ر.س ' => ' <span class="icon-saudi_riyal"></span> ',
            'ر.س. ' => ' <span class="icon-saudi_riyal"></span> ',
            ' SAR' => ' <span class="icon-saudi_riyal"></span>',
            ' ر.س' => ' <span class="icon-saudi_riyal"></span>',
            ' ر.س.' => ' <span class="icon-saudi_riyal"></span>',
        ];

        // استبدال الرموز في النص
        $text = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $text
        );

        // معالجة تنسيق العملة باستخدام Number::currency
        if (strpos($text, 'Number::currency') !== false) {
            $text = preg_replace_callback(
                '/Number::currency\(([^,]+),\s*([^,]+),\s*([^)]+)\)/',
                function ($matches) {
                    $price = trim($matches[1]);
                    $currency = trim($matches[2]);
                    $locale = trim($matches[3]);
                    
                    // إذا كانت العملة هي الريال السعودي
                    if (in_array($currency, ['SAR', 'ر.س', 'ر.س.'])) {
                        return self::formatPrice($price, $locale);
                    }
                    
                    return $matches[0];
                },
                $text
            );
        }

        // معالجة Livewire data
        if (strpos($text, 'wire:') !== false) {
            $text = preg_replace_callback(
                '/"([^"]+)":\s*([^,}]+)/',
                function ($matches) {
                    $key = $matches[1];
                    $value = $matches[2];
                    
                    // إذا كان المفتاح يتعلق بالسعر أو العملة
                    if (in_array($key, ['price', 'amount', 'total', 'currency'])) {
                        if (is_numeric($value)) {
                            return '"' . $key . '": ' . self::formatPrice($value);
                        }
                        return '"' . $key . '": ' . self::replaceSymbols($value);
                    }
                    
                    return $matches[0];
                },
                $text
            );
        }

        // إضافة مسافة قبل الرمز إذا لم تكن موجودة
        $text = preg_replace('/(\d+)(<span class="icon-saudi_riyal">)/', '$1 $2', $text);

        return $text;
    }
} 