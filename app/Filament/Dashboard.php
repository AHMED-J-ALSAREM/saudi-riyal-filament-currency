<?php

namespace App\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;

class Dashboard extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dashboard')
            ->path('dashboard')
            ->assets([
                Css::make('saudi-riyal-symbol', 'https://cdn.jsdelivr.net/npm/@emran-alhaddad/saudi-riyal-font/index.css'),
            ]);
    }
} 