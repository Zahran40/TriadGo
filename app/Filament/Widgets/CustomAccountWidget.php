<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget as BaseAccountWidget;

class CustomAccountWidget extends BaseAccountWidget
{
    protected static ?int $sort = -2;
    
    protected int | string | array $columnSpan = 1;
}
