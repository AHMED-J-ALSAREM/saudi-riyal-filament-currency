<?php

namespace AhmedJAlsarem\SaudiRiyal\FilamentCurrency\Services;

use Illuminate\Support\Number;

class SaudiRiyalFormatter
{
    /**
     * Format a number as Saudi Riyal with the new symbol
     */
    public static function format($amount): string
    {
        $formatted = number_format(floatval($amount), 2);
        return $formatted . ' <span class="icon-saudi_riyal"></span>';
    }

    /**
     * استبدال رموز الريال السعودي بالرمز الجديد
     */
    public static function replaceSymbols($text): string
    {
        if (!is_string($text)) {
            return $text;
        }

        // استبدال جميع أشكال الرمز
        $replacements = [
            'SAR' => '<span class="icon-saudi_riyal"></span>',
            'ر.س' => '<span class="icon-saudi_riyal"></span>',
            'ر.س.' => '<span class="icon-saudi_riyal"></span>',
            'SAR ' => '<span class="icon-saudi_riyal"></span> ',
            'ر.س ' => '<span class="icon-saudi_riyal"></span> ',
            'ر.س. ' => '<span class="icon-saudi_riyal"></span> ',
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
                        $formatted = Number::currency($price, $currency, $locale);
                        return str_replace($currency, '<span class="icon-saudi_riyal"></span>', $formatted);
                    }
                    
                    return $matches[0];
                },
                $text
            );
        }

        return $text;
    }
} 