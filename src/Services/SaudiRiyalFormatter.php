<?php

namespace AhmedJAlsarem\SaudiRiyal\FilamentCurrency\Services;

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

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $text
        );
    }
} 