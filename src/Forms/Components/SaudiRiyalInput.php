<?php

namespace SaudiRiyal\FilamentCurrency\Forms\Components;

use Filament\Forms\Components\TextInput;
use SaudiRiyal\FilamentCurrency\CurrencyFormatter;

class SaudiRiyalInput extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->prefix('<span class="icon-saudi_riyal"></span>');
        $this->numeric();
        $this->inputMode('decimal');
        $this->step(0.01);
        $this->minValue(0);
        $this->extraInputAttributes(['class' => 'filament-currency-input']);
    }

    public function getDisplayValue(): string
    {
        return CurrencyFormatter::format($this->getState());
    }
} 