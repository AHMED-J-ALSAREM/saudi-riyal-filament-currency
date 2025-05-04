<?php

namespace App\Providers;

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
                Css::make('saudi-riyal-symbol', 'https://cdn.jsdelivr.net/npm/@emran-alhaddad/saudi-riyal-font/index.css')
                    ->loadedOnRequest(),
            ]);
    }
} 