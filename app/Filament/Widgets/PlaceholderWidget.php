<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class PlaceholderWidget extends Widget
{
    protected static string $view = 'filament.widgets.placeholder-widget';
    
    protected static ?int $sort = 8;
    protected int | string | array $columnSpan = 6;
    
    protected static bool $isLazy = false;
    
    public function getHeading(): ?string
    {
        return null;
    }
}
