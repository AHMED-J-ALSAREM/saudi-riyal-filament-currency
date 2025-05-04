<?php

namespace SaudiRiyal\FilamentCurrency\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use SaudiRiyal\FilamentCurrency\CurrencyFormatter;

class SaudiRiyalColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(fn ($state) => CurrencyFormatter::format($state));
        $this->html();
    }
} 