<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class TriadGoInfoWidget extends Widget
{
    protected static string $view = 'filament.widgets.triadgo-info-widget';
    
    protected static ?int $sort = -1;
    
    protected int | string | array $columnSpan = 1;
}
