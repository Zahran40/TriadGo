<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class EmptySpaceWidget extends Widget
{
    protected static string $view = 'filament.widgets.empty-space-widget';
    
    protected static ?int $sort = 7;
    protected int | string | array $columnSpan = 6;
}
